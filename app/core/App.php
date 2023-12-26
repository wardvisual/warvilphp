<?php

namespace app\core;

use app\core\{Router, RouterApi};

use app\controllers\{HomeController};

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = isset($_GET['url']) ? '/' . $_GET['url'] : '/';
        $requestType = $_SERVER['REQUEST_METHOD'];

        if (strpos($url, '/api') === 0) {
            RouterApi::dispatch($url, $requestType);
        } else {
            Router::dispatch($url, $requestType);
        }
    }

    public static function isProduction()
    {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            return false;
        } else {
            return true;
        }
    }
}
