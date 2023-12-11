<?php

namespace app\core;

class Response
{
    public static function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    // status code
    public static function status($code)
    {
        http_response_code($code);

        return new static;
    }
}
