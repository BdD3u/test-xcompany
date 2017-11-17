<?php
//!!! По тз: "скрипт должен запускаться по любому пути – в корне, в подпапке и т.д."
namespace App\Controllers;

use Core\Application;
use Core\ControllerInterface;

class CssController implements ControllerInterface
{
    protected $app;
    protected $dir;
    protected $headers;

    public function __construct()
    {
        $this->app = Application::instance();
        $this->dir = $this->app->getConfig()->get('cssDir');
        $this->headers['contentType'] = 'Content-type:text/css';
        $this->fileExtension = 'css';
    }

    protected function buildPath(string $fileName): string
    {
        return $this->dir . '/' . $fileName . '.' . $this->fileExtension;
    }

    public function indexAction()
    {

        if(isset($_GET['file'])
            && ($file = filter_var($_GET['file'], FILTER_SANITIZE_STRING))) {

            $path = $this->buildPath($file);
            if(is_file($path)) {
                header('Content-type:text/css');
                readfile($path);
                die();
                //$this->app->getPage()->addView($path, []);
                //return;
            }

        }

        $this->app->getRouter()->routingTo404();
    }


}