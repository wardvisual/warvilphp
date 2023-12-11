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
        switch ($type) {
            case 'POST':
                return (!empty($_POST)) ? true : false;
                break;

            case 'GET':
                return (!empty($_GET)) ? true : false;
                break;

            default:
                return false;
                break;
        }
    }

    public static function input($item)
    {
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }

    // requst body
    public static function body()
    {
        $body = file_get_contents('php://input');
        $body = json_decode($body, true);
        return $body;
    }
}
