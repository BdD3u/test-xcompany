<?php
namespace App\Controllers;

use App\Components\Mail\Component as MailComponent;
use App\Models\PhotoFormModel;
use App\Models\PhotoModel;
use Core\ControllerAbstract;
use Core\Mail;

class IndexController extends ControllerAbstract
{

    protected static function getBaseDirViews(): string
    {
        return 'App/Views';
    }

    protected static function getLayout(): string
    {
        return 'layouts/main.php';
    }

    public function indexAction()
    {
        if($this->app->getRequest()->isAjax()) {
            // Сброс шаблона если ajax.
            $this->page->setLayout();
        }
        if($this->app->getRequest()->isPost()) {
           // Пробует загрузить.
           $res['uploadPhotos'] = PhotoFormModel::uploadPhotos();
        }
        if(isset($res['uploadPhotos']['uploaded']) && $res['uploadPhotos']['uploaded']) {
            // отправка уведомления админу.
            $message = MailComponent::getHtml($res['uploadPhotos']['uploaded'], 'default.php');
            $emailAdmin = $this->app->getConfig()->get('emailAdmin');
            $this->app->getMail()->send($emailAdmin, 'Добавлены новые файлы', $message);
        }
        $res['captcha'] = PhotoFormModel::getCaptchaParams();
        $this->page->setTitle('Загрузка фотографий');
        $res['photos'] = PhotoModel::findAll();
        $this->render('photo/index.php', $res);
    }

    public function aboutTestAction()
    {
        $this->page->setTitle('ТЕСТОВОЕ ЗАДАНИЕ');
        $this->render('about-test.php', []);
    }

    public function err404Action()
    {
        header('Status: 404 Not Found');
        $this->page->setTitle('404');
        $this->render('404.php', []);
    }
}