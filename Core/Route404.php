<?php
namespace Core;
/**
 * Class Route404
 * @package Core
 */
class Route404 extends RouteAbstract
{
    protected $inpControllerN;
    protected $inpActionN;

    public function __construct(string $controllerName, string $actionName)
    {
        $this->inpControllerN = $controllerName;
        $this->inpActionN = $actionName;
    }

    public function isActive()
    {
        if(!$this->trySetCtrlAct($this->inpControllerN, $this->inpActionN)) {
            throw new \ErrorException('Ошибка маршрутизации к 404.');
        }
        return $this->isActive;
    }

    public function is404()
    {
        return true;
    }

    public function execute()
    {
        if(!$this->isActive) {
            $this->isActive();
        }
        parent::execute();
    }
}