<?php

namespace app\core;

class Storage
{
    static protected $uploadDir;
    static protected $allowedExtensions =  [];
    static protected $maxSize;

    public static function load()
    {
        self::$uploadDir = CURRENT_DIR . Config::get('config/storage/directory');
        self::$allowedExtensions = Config::get('config/storage/allowed_types');
        self::$maxSize = Config::get('config/storage/max_size');
    }

    public static function uploadFile($file)
    {
        self::load();
        if (!self::validateFile($file)) {
            return false;
        }

        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . $originalName . '.' . $extension;
        $fileTmpName = $file['tmp_name'];
        $destination = self::$uploadDir . '/' . $fileName;

        if (move_uploaded_file($fileTmpName, $destination)) {
            return $destination;
        }

        return false;
    }

    public static function deleteFile($fileName)
    {
        self::load();

        $filePath = self::$uploadDir . '/' . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }

        return false;
    }

    public static function getFile($fileName)
    {
        self::load();
        $filePath = self::$uploadDir . '/' . $fileName;

        if (file_exists($filePath)) {
            return $filePath;
        }

        return false;
    }

    public static function validateFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $size = $file['size'];

        // Check the file extension
        if (!in_array($extension, self::$allowedExtensions)) {
            return false;
        }

        // Check the file size
        if ($size > self::$maxSize) {
            return false;
        }

        return true;
    }
}
