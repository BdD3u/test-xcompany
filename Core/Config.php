<?php
namespace Core;

/**
 * Class Config
 * @package Core
 */
class Config
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $key) {
        if(!isset($this->config[$key])) {
            throw new \ErrorException('Конфиг по индексу "' . $key . '" не найден.');
        }
        return $this->config[$key];
    }
}