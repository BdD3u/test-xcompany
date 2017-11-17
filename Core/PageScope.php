<?php
namespace Core;

/**
 * Class PageScope
 * @package Core
 */
class PageScope
{
    public static function page(PageRenderer $pr, string $layoutPath = null)
    {
        include $layoutPath;
    }

    public static function content($path, $params)
    {
        include $path;
    }
}