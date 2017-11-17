<?php
namespace Core;
/**
 * Class RouteAbstract
 * @package Core
 */
abstract class RouteAbstract implements RouteInterface
{
    protected $isActive;
    protected $ctrlClassName;
    protected $actionName;

    protected function trySetCtrlAct(string $ctrlClassName, string $actionMethodName): bool
    {
        if(is_subclass_of($ctrlClassName, static::CTRL_INTERFACE)
            && in_array($actionMethodName, get_class_methods($ctrlClassName))) {
            $this->ctrlClassName = $ctrlClassName;
            $this->actionName = $actionMethodName;
            $this->isActive = true;
        } else {
            $this->isActive = false;
        }
        return $this->isActive;
    }

    public static function toCamelCase(string $str, string $separator = '-', bool $rmSeparator = true)
    {
        if($rmSeparator) {
            return str_replace($separator, '', ucwords($str, $separator));
        } else {
            return ucwords($str, $separator);
        }
    }

    public function execute()
    {
        if(!$this->isActive) {
            throw new \ErrorException('Вызван неактивный роутер.');
        }
        $class = $this->ctrlClassName;
        $method = $this->actionName;
        (new $class)->$method();
    }

    public function is404() {
        return false;
    }
}