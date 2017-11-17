<?php
namespace Core;
/**
 * Interface RouterInterface
 * @package Core
 */
interface RouterInterface {
  function addRoute(RouteInterface $route);
  function routing();
}