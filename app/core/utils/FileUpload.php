<?php

namespace app\backend\helpers;

class FileUploadHelper
{
    private $targetDirectory;
    private $imageAllowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];

    public function __construct($targetDirectory = 'uploads')
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function uploadFile($fileInputName)
    {
        if (!isset($_FILES[$fileInputName])) {
            return false; // File input not found
        }

        $file = $_FILES[$fileInputName];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false; // File upload error
        }

        // Generate a unique filename based on a timestamp and the original file's extension
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '-' . uniqid() . '.' . $fileExtension;
        $uploadPath = $this->targetDirectory . '/' . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $uploadPath; // Successful upload
        } else {
            return false; // Failed to move the uploaded file
        }
    }


    public function isFileTypeAllowed($fileInputName, $allowedFileTypes)
    {
        if (!isset($_FILES[$fileInputName])) {
            return false;
        }

        $file = $_FILES[$fileInputName];
        $fileType = mime_content_type($file['tmp_name']);

        return in_array($fileType, $allowedFileTypes);
    }
}
