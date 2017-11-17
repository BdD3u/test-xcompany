<?php
//!!! По тз: "скрипт должен запускаться по любому пути – в корне, в подпапке и т.д."
namespace App\Controllers;

use App\Models\PhotoModel;
use Core\Application;
use Core\ControllerInterface;

class ImageController implements ControllerInterface
{
    public function indexAction()
    {
        if (isset($_GET['id']) && ($id = intval($_GET['id']))) {
            /** @var PhotoModel[] $res */
            if ($res = PhotoModel::getById($id)) {
                $uploadDir = Application::instance()->getConfig()->get('uploadDir');
                $path = $uploadDir . '/' . $res[0]->name;
                $this->renderImage($path);
            }
        } elseif (isset($_GET['id']) && 'preloader' === $_GET['id']) {
            $uploadDir = Application::instance()->getConfig()->get('uploadDir');
            $path = $uploadDir . '/' . 'preloader.gif';
            $this->renderImage($path);
        }
        Application::instance()->getRouter()->routingTo404();
    }

    public function previewAction()
    {
        if(isset($_GET['id']) && ($id = intval($_GET['id']))) {
            /** @var PhotoModel[] $res */
            if($res = PhotoModel::getById($id)) {
                $uploadDir = Application::instance()->getConfig()->get('uploadDir');
                $path = $uploadDir . '/' . $res[0]->name_preview;
                $this->renderImage($path);
            //} else {
            //    Application::instance()->getRouter()->routingTo404();
            }
        }
            Application::instance()->getRouter()->routingTo404();
    }

    protected function renderImage(string $path)
    {
        if(is_file($path)) {
            header('Content-Type: ' . mime_content_type($path));
            readfile($path);
            die();
        }
//        else {
//            Application::instance()->getRouter()->routingTo404();
//        }
    }
}