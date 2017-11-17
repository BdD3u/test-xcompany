<?php
namespace Core;
/**
 * Class Router
 * @package Core
 */
class Router implements RouterInterface
{
  /** @var RouteInterface[] $registryRoutes */
  protected $registryRoutes;
  /** @var  RouteInterface $routeTo404 */
  protected $routeTo404;

  public function __construct()
  {
      $this->registryRoutes = [];
  }

  public function addRoute(RouteInterface $route)
  {
    if($route->is404()) {
        $this->routeTo404 = $route;
        return;
    }

    $hash = spl_object_hash($route);
    if(!isset($this->registryRoutes[$hash])) 
    {
      $this->registryRoutes[$hash] = $route;
    }
  }

  public function routing(): bool
  {
      $found = false;
      foreach($this->registryRoutes as $route) {
          if($route->isActive()) {
              $found = true;
              $route->execute();
              break;
          }
      }
      if(!$found && isset($this->routeTo404) && $this->routeTo404->isActive()) {
          $found = true;
          $this->routeTo404->execute();
      }
      return $found;
  }

  public function routingTo404()
  {
      if($this->routeTo404 === null) {
          throw new \ErrorException('Маршрутизация к ошибке 404 не инициализирована.');
      }

      $this->routeTo404->execute();
  }

}