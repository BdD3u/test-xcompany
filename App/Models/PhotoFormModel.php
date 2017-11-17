<?php

namespace App\Models;

use Core\Application;
use Core\ImageHelper;

class PhotoFormModel
{
    public static function uploadPhotos(): array
    {
        $app = Application::instance();
        $isPost = $app->getRequest()->isPost();
        $resUpload = [
            'uploaded' => [],
            'errors' => [],
        ];


        if (!isset($_POST['captcha']) || !static::validateCaptcha($_POST['captcha'])) {
            $resUpload['errors'][] = 'Неправильный ответ на вопрос из Captcha.';
            return $resUpload;
        }

        $isUpload = isset($_FILES['file']['tmp_name'][0])
            && $_FILES['file']['tmp_name'][0] != null
            && isset($_POST['file'][0]['name']);

        // Загрузка изображений
        if ($isPost && $isUpload) {

            $dirUpload = $app->getPathResolver()->getCheckedDirPath(
                $app->getConfig()->get('uploadDir')
            );

            $uplTmpFiles =& $_FILES['file']['tmp_name'];
            $length = count($uplTmpFiles);
            $allowedTypes = ['image/jpeg', 'image/gif', 'image/png'];

            for ($i = 0; $i < $length; $i++) {

                // что-то не так...
                if (!(isset($_POST['file'][$i]['name']) && $_POST['file'][$i]['name']
                    && isset($uplTmpFiles[$i]['file']) && $uplTmpFiles[$i]['file'])
                ) {
                    $resUpload['errors'][] = "Отмена загрузки файла ({$_FILES['file']['name'][$i]['file']})."
                        . " Все поля обязательны для заполнения.";;
                    continue;
                }

                // Проверка типа изображения
                if (!in_array($_FILES['file']['type'][$i]['file'], $allowedTypes)) {
                    $resUpload['errors'][] = "Отмена загрузки файла ({$_FILES['file']['name'][$i]['file']})."
                        . "Формат не поддерживается, поддерживаемые форматы png, jpeg, gif";
                    continue;
                }

                // ошибки загрузки.
                if ($_FILES['file']['error'][$i]['file'] !== 0) {
                    $fileName = $_FILES['file']['name'][$i]['file'];
                    $errNumb = $_FILES['file']['error'][$i]['file'];

                    switch ($errNumb) {
                        case 1:
                            $resUpload['errors'][] = "У файла слишком большой размер ($fileName).";
                            break;
                        case 2:
                            $resUpload['errors'][] = "У файла слишком большой размер ($fileName).";
                            break;
                        case 3:
                            $resUpload['errors'][] = "Файл был загружен частично ($fileName). Отмена загрузки.";
                            break;
                        case 4:
                            $resUpload['errors'][] = "Не удалось загрузить файл ($fileName).";
                            break;
                        default:
                            $resUpload['errors'][] = "Ошибка загрузки файла ($fileName).";
                    }
                    continue;
                }

                $tmpFile = [];
                $infoFile = pathinfo($_FILES['file']['name'][$i]['file']);

                // Уменьшние до 500*500
                $newPath = $dirUpload . '/' . md5($uplTmpFiles[$i]['file'] . microtime(true)) . '.' . $infoFile['extension'];
                if (ImageHelper::resize($uplTmpFiles[$i]['file'], $newPath, 500, 500)) {
                    $pathInfoName = pathinfo($newPath);
                    $tmpFile['name'] = $pathInfoName['basename'];
                }
                // Уменьшение до 100*100
                $newPath = $dirUpload . '/' . md5($uplTmpFiles[$i]['file'] . microtime(true)) . '.' . $infoFile['extension'];
                if (ImageHelper::resize($uplTmpFiles[$i]['file'], $newPath, 100, 100)) {
                    $pathInfoName = pathinfo($newPath);
                    $tmpFile['name_preview'] = $pathInfoName['basename'];
                }
                // Если все ок, то добавить в массив $resUpload
                if ($tmpFile['name'] && $tmpFile['name_preview']) {
                    $tmpFile['type'] = $_FILES['file']['type'][$i];
                    $tmpFile['name_origin'] = $_FILES['file']['name'][$i]['file'];
                    $tmpFile['title'] = strip_tags($_POST['file'][$i]['name']);
                    $resUpload['uploaded'][] = $tmpFile;
                }
            }
        }

        // запись в бд
        foreach ($resUpload['uploaded'] as &$fileInfo) {
            $photo = new PhotoModel();
            $photo->name = $fileInfo['name'];
            $photo->name_preview = $fileInfo['name_preview'];
            $photo->name_origin = $fileInfo['name_origin'];
            $photo->title = $fileInfo['title'];
            if($photo->save()) {
                $fileInfo['id'] = PhotoModel::getDbConnection()->getLastInsertId();
            } else {
                // если не сохранилось в бд.
                $dPath = $dirUpload . '/' . $fileInfo['name'];
                $dPathPreview = $dirUpload . '/' . $fileInfo['name_preview'];

                if(is_file($dPath)) {
                    unlink($dPath);
                }
                if(is_file($dPathPreview)) {
                    unlink($dPathPreview);
                }

                $resUpload['errors'][] = "Не удалось загрузить файл {$fileInfo['name_origin']}.";
                unset($fileInfo);
            }

        }

        return $resUpload;
    }

    public static function getCaptchaParams(): array
    {
        $res['numb1'] = rand(1, 10);
        $res['numb2'] = rand(1, 10);
        $res['answer'] = $res['numb1'] + $res['numb2'];
        $res['question'] = "{$res['numb1']} + {$res['numb2']} = ?";
        $_SESSION['captcha_' . __CLASS__] = $res;
        return $res;
    }

    public static function validateCaptcha($answer): bool
    {
        $res = false;
        if (isset($_SESSION['captcha_' . __CLASS__]['answer'])
            && ($answer = intval($answer))
        ) {
            $res = $answer === $_SESSION['captcha_' . __CLASS__]['answer'];
        }
        return $res;
    }
}