<?php
namespace App\Models;

use Core\ActiveRecordAbstract;
use Core\Application;
use Core\ImageHelper;

class PhotoModel extends ActiveRecordAbstract
{
    public $name;
    public $name_preview;
    public $name_origin;
    public $title;

    public static function getTableName(): string
    {
        return 'photos';
    }
}