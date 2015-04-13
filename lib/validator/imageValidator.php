<?php
/**
 * Created by PhpStorm.
 * User: newapple
 * Date: 11.04.15
 * Time: 22:41
 */
class ImageValidator
{
    //Constants
    const kUploadDir = "/uploads";
    const kImagesUploadDir = "/images";
    const kArticleUploadDir = "/article/";

    const kArticleType = "article";

    /**
     *  This method validates given file to determine upload type and file type
     * if everything is OK, method returns new file name, else - null
     * @return string
     */
    public static function validateFile($fileName, $fileTampName, $type)
    {
        if($type == self::kArticleType && $fileName && $fileTampName) {
            $filePath = self::kUploadDir . self::kImagesUploadDir . self::kArticleUploadDir . $fileName;
            $imageFileType = pathinfo($filePath, PATHINFO_EXTENSION);
            $check = getimagesize($fileTampName);
            if(!$check)
                return null;
            elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" )
                return null;
            else
                return self::generateNewFilename($fileName, $fileTampName, $imageFileType);
        }
        return null;
    }


    public static function uploadFile($fileTempName, $fileName)
    {
        $filePath = self::getBaseFilePath() . $fileName;
        move_uploaded_file($fileTempName, $filePath);
    }

    private static function generateNewFilename($fileName, $fileTampName, $ext)
    {
        return md5($fileName.$fileTampName.time()).".".$ext;
    }

    public static function getBaseFilePath()
    {
        return dirname(__FILE__) . "/../../" . self::kUploadDir . self::kImagesUploadDir . self::kArticleUploadDir;
    }

    public static function getBaseArticleSRC()
    {
        return self::kUploadDir . self::kImagesUploadDir . self::kArticleUploadDir;
    }
}