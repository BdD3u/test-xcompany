<?php
namespace Core;
/**
 * Interface RouteInterface
 * @package Core
 */
interface RouteInterface {
    const CTRL_INTERFACE = ControllerInterface::class;
  	const CTRL_DEFAULT_NAME = 'IndexController';
  	const CTRL_SUFFIX = 'Controller';
	const CTRL_DEFAULT_ACTION = 'indexAction';
    const CTRL_ACTION_SUFFIX = 'Action';
  
    public function isActive();
    public function is404();
  	public function execute();
}