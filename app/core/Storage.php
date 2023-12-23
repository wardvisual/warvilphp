<?php

namespace app\core;

class Storage
{
    protected $uploadDir;
    protected $allowedExtensions;
    protected $maxSize;

    public function __construct()
    {
        $this->uploadDir = Config::get('storage/directory');
        $this->allowedExtensions = Config::get('storage/allowed_types');
        $this->maxSize = Config::get('storage/max_size');;
    }

    public function uploadFile($file)
    {
        if (!$this->validateFile($file)) {
            return false;
        }

        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . $originalName . '.' . $extension;
        $fileTmpName = $file['tmp_name'];
        $destination = $this->uploadDir . '/' . $fileName;

        if (move_uploaded_file($fileTmpName, $destination)) {
            return $destination;
        }

        return false;
    }

    public function deleteFile($fileName)
    {
        $filePath = $this->uploadDir . '/' . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }

        return false;
    }

    public function getFile($fileName)
    {
        $filePath = $this->uploadDir . '/' . $fileName;

        if (file_exists($filePath)) {
            return $filePath;
        }

        return false;
    }

    public function validateFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $size = $file['size'];

        // Check the file extension
        if (!in_array($extension, $this->allowedExtensions)) {
            return false;
        }

        // Check the file size
        if ($size > $this->maxSize) {
            return false;
        }

        return true;
    }
}
