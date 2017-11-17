<?php
namespace Core;

class ImageHelper
{
    public static function resize(string $path, string $pathNewImg, int $height, int $width)
    {
        $info = getimagesize($path);

        $currImg = [
            'pathOrigin' => $path,
            'width' => $info[0],
            'height' => $info[1],
            'type' => $info[2] // Индекс 2 содержит одну из констант типа изображения IMAGETYPE_XXX
        ];

        if ($height < $currImg['height'] || $width < $currImg['width']) {

            switch ($currImg['type']) {
                case IMAGETYPE_JPEG:
                    $currImg['image'] = imagecreatefromjpeg($currImg['pathOrigin']);
                    $currImg['saveFunc'] = 'imagejpeg';
                    break;
                case IMAGETYPE_PNG:
                    $currImg['image'] = imagecreatefrompng($currImg['pathOrigin']);
                    $currImg['saveFunc'] = 'imagepng';
                    break;
                case IMAGETYPE_GIF:
                    $currImg['image'] = imagecreatefromgif($currImg['pathOrigin']);
                    $currImg['saveFunc'] = 'imagegif';
                    break;
                default:
                    throw new \Exception('Изображения данного типа не поддерживаются.');
            }

            $scaleH = round($height / $currImg['height'], 2);
            $scaleW = round($width / $currImg['width'], 2);
            $scale = $scaleW > $scaleH ? $scaleH : $scaleW;

            $newHeight = floor($currImg['height'] * $scale);
            $newWidth = floor($currImg['width'] * $scale);
            $newImg = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled($newImg, $currImg['image'], 0, 0, 0, 0,
                $newWidth, $newHeight, $currImg['width'], $currImg['height']);
            $resizeOk = $currImg['saveFunc']($newImg, $pathNewImg);
            imagedestroy($newImg);
            imagedestroy($currImg['image']);
        } else {
            $resizeOk = copy($path, $pathNewImg);
        }

        return $resizeOk;
    }
}
