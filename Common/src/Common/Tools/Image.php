<?php
namespace Common\Tools;

class Image
{

    /**
     *
     * Enter description here ...
     * @param unknown_type $image
     * @param unknown_type $width
     * @param unknown_type $height
     * @param unknown_type $scale
     */
    public static function resizeImage($image, $width, $height, $scale)
    {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);
        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);

        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $image, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $image);
                break;
        }

        chmod($image, 0777);
        return $image;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $thumbImageName
     * @param unknown_type $image
     * @param unknown_type $width
     * @param unknown_type $height
     * @param unknown_type $startWidth
     * @param unknown_type $startHeight
     * @param unknown_type $scale
     */
    public static function resizeThumbnailImage(
        $thumbImageName,
        $image,
        $width,
        $height,
        $startWidth,
        $startHeight,
        $scale
    ) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);

        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled(
            $newImage,
            $source,
            0,
            0,
            $startWidth,
            $startHeight,
            $newImageWidth,
            $newImageHeight,
            $width,
            $height
        );
        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $thumbImageName);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $thumbImageName, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $thumbImageName);
                break;
        }
        chmod($thumbImageName, 0777);
        return $thumbImageName;
    }

    /**
     * Return height of an image
     * @param string $fileName
     */
    public static function getHeight($fileName)
    {
        $size = getimagesize($fileName);
        $height = $size[1];
        return $height;
    }


    /**
     * Return width of an image
     * @param string $fileName
     */
    public static function getWidth($fileName)
    {
        $size = getimagesize($fileName);
        $width = $size[0];
        return $width;
    }

}