<?php
namespace Core;

/**
 * Простая автоподгрузка, без усложнений...
 *
 * Class Autoload
 * @package Core
 */
class Autoload
{
    protected $rootDir;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
        spl_autoload_register([$this, 'autoload'], true, false);
    }

    protected function autoload($className)
    {
        $prepPathChunk = str_replace('\\', '/', $className);

        $path = $this->rootDir . '/' . $prepPathChunk . '.php';
        if(is_file($path)) {
            include $path;
        }
    }
}