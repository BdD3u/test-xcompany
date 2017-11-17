<?php
//!!! По тз: "скрипт должен запускаться по любому пути – в корне, в подпапке и т.д."
namespace App\Controllers;
use Core\Application;

class JsController extends CssController
{
    public function __construct()
    {
        $this->app = Application::instance();
        $this->dir = $this->app->getConfig()->get('jsDir');
        $this->headers['contentType'] = 'Content-type:text/javascript';
        $this->fileExtension = 'js';
    }
}