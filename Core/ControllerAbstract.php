<?php
namespace Core;

abstract class ControllerAbstract implements ControllerInterface
{
    protected $dirViews;
    protected $layout;
    /** @var Application $app */
    protected $app;
    protected $page;
    protected $pathResolver;

    public function __construct()
    {
        $this->app = Application::instance();
        $this->page = $this->app->getPage();
        $this->pathResolver = $this->app->getPathResolver();

        // set params for views
        $this->dirViews = static::getBaseDirViews();
        $this->layout = static::getLayout();
        if ($this->dirViews && $this->layout) {
            $this->page->setLayout($this->pathFileResolver($this->layout));
        }
    }

    protected function pathFileResolver(string $path): string {
        if($this->pathResolver->isRelativePath($path) && $this->dirViews) {
            $viewPath = $this->pathResolver->getCheckedFilePath($this->dirViews . '/' . $path);
        } else {
            $viewPath = $this->pathResolver->getCheckedFilePath($path);
        }
        return $viewPath;
    }

    /**
     * Добавляет представление в очередь на отрисовку.
     * @param string|null $view
     * @param array $params
     */
    public function render(string $view = null, array $params = [])
    {
        $viewPath = $this->pathFileResolver($view);
        $this->page->addView($viewPath, $params);
    }

    /**
     * Хелпер возвращает путь папке с шаблонами.
     * @return string
     */
    protected abstract static function getBaseDirViews(): string;

    /**
     * Хелпер возвращет путь к оснвному шаблону.
     * @return string
     */
    protected abstract static function getLayout(): string;
}