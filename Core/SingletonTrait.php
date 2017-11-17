<?php
namespace Core;
/**
 * Trait SingletonTrait
 * @package Core
 */
trait SingletonTrait
{
    static protected $instance;

    public static function instance()
    {
        if(static::$instance === NULL) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    protected function __construct(){}
    protected function __clone() {}
    protected function __sleep() {}
    protected function __wakeup() {}
    protected function __set_state() {}
}