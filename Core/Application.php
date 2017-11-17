<?php
namespace Core;

/**
 * Class Application
 * @package Core
 * @method static Application instance()
 */
class Application implements SingletonInterface
{
    use SingletonTrait;

    protected $isRunning;
    protected $config;
    protected $request;
    protected $router;
    protected $pathResolver;
    protected $page;
    protected $dbConnection;
    protected $mail;

    protected function __construct()
    {
        $this->isRunning = false;
    }

    /**
     * Вспомагательный метод, для запуска.
     * @param array $config
     */
    public static function run(array $config)
    {
        if (!$config['debug']) {
            error_reporting(0);
        } else {
            error_reporting(E_ALL);
        }

        try {
            static::instance()->bootstrap($config);
        } catch (\Exception $e) {
            if ($config['debug']) {
                static::printException($e);
            }
        }
    }

    public static function printException(\Exception $e)
    {
        $err = $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ') ' . PHP_EOL . PHP_EOL .
            $e->getTraceAsString();

        if (php_sapi_name() === 'cli') {
            echo $err;
        } else {
            echo '<pre>', $err, '</pre>';
        }
    }

    public function bootstrap(array &$config)
    {
        if($this->isRunning) {
            throw new \ErrorException('Уже запущено.');
        }
        session_start();

        $this->isRunning = true;
        // init Config
        $this->config = static::createConfig($config);
        $this->dbConnection = $this->createDbConn();
        $this->request = new Request();
        $this->router = $this->createRouter();
        $this->pathResolver = new PathResolver($this->config->get('rootDir'));
        $this->page = $this->createPage();
        $this->mail = new Mail($this->config->get('email'));

        if($this->router->routing()) {
            echo $this->getPage()->render();
        } else {
            echo '[404] Not found.';
        }
    }

    public function getMail(): Mail
    {
        return $this->mail;
    }

    protected function createDbConn(): Connection
    {
        $config = $this->getConfig()->get('db');
        if(!isset($config['dsn'])) {
            throw new \ErrorException('Не найден dsn для подключения к базе.');
        }
        if(!isset($config['user'])) {
            throw new \ErrorException('Имя пользователя для базы не определено');
        }
        if(!isset($config['password'])) {
            $config['password'] = '';
        }

        $db = new Connection($config['dsn'], $config['user'], $config['password']);
        if(isset($config['connQuery'])) {
            $db->query($config['connQuery']);
        }
        return $db;
    }

    public function getDbConnection(): Connection
    {
        return $this->dbConnection;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    protected static function createConfig(array &$config): Config
    {
        return new Config($config);
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    protected function createRouter(): Router
    {
        $router = new Router();

        $currUrl = $this->getRequest()->getUrl();
        $confRoutesByNs = $this->getConfig()->get('routesByNs');
        $confRoute404 = $this->getConfig()->get('routeTo404');

        // Включить роутинг по Namespace\ClassName
        foreach ($confRoutesByNs as $ns=>$bUrl) {
            if(!is_string($bUrl) || $bUrl === '') {
                throw new \ErrorException('Базовый url должен быть непустой строкой');
            }
            $router->addRoute(new RouteByNs($currUrl, $ns, $bUrl));
        }

        // Включить роутинг к 404.
        if(!is_string($confRoute404)) {
            throw new \ErrorException('Неправильный формат маршрута для ошибки 404.');
        }
        $conf404Parsed = explode('::', $confRoute404);
        if(count($conf404Parsed) !== 2) {
            throw new \ErrorException(
                'Кофигурация маршрута 404 не соответсвует формату ClassName::methodAction'
            );
        }
        $router->addRoute(new Route404($conf404Parsed[0], $conf404Parsed[1]));


        return $router;
    }

    public function getPathResolver(): PathResolver
    {
        return $this->pathResolver;
    }

    protected function createPage(): Page
    {
        return new Page(
            $this->getPathResolver(),
            new PageRenderer(new PageScope())
        );
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }


}