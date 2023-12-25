<?php

namespace app\core;

class Request
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPostMethod(): bool
    {
        return self::method() === 'POST';
    }

    public static function isGetMethod(): bool
    {
        return self::method() === 'GET';
    }

    public static function exists($type = 'POST')
    {
        $requestData = ($type === 'POST') ? $_POST : $_GET;
        return !empty($requestData);
    }

    public static function input($item)
    {
        $inputs = array_merge($_POST, $_GET, $_FILES);

        // Check if the content type is JSON
        if (strpos($_SERVER["CONTENT_TYPE"], 'application/json') !== false) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            $inputs = array_merge($inputs, $jsonData ? $jsonData : []);
        }

        return $inputs[$item] ?? '';
    }

    public static function file($item)
    {
        if (isset($_FILES[$item])) {
            return $_FILES[$item];
        }

        return '';
    }

    public static function body()
    {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);
        return $body;
    }
}
