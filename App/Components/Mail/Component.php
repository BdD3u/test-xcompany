<?php
namespace App\Components\Mail;
use Core\ComponentAbstract;

class Component extends ComponentAbstract
{
    protected static function getBaseDir(): string
    {
        return __DIR__;
    }

    protected function init()
    {
        $this->res = $this->params;
    }
}