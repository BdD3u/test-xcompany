<?php
namespace Core;

abstract class ComponentAbstract
{
    protected $params;
    protected $templatePath;
    protected $res;

    protected function __construct(array $params, string $templatePath)
    {
        $path = static::getBaseDir() . '/views/' . $templatePath;
        if(!is_file($path)) {
            throw new \ErrorException("Не найден файл {$path}.");
        }
        $this->params = $params;
        $this->templatePath = $path;

        $this->init();
    }

    abstract protected static function getBaseDir(): string ;

    abstract protected function init();

    protected function render()
    {
        static::includeView($this->templatePath, $this->res);
    }

    protected static function includeView(string $path, array $res)
    {
        include $path;
    }

    public static function getHtml(array $params, string $templatePath): string
    {
        $self = new static($params, $templatePath);
        ob_start();
            $self->render();
        return ob_get_clean();
    }

}