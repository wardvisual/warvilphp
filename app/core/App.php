<?php

namespace app\core;

use app\core\{Router, RouterApi};

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        // Determine the URL from either the 'url' parameter or REQUEST_URI
        if (isset($_GET['url'])) {
            $url = '/' . trim($_GET['url'], '/');
        } else {
            $url = $_SERVER['REQUEST_URI'];
            // Remove query string if present
            if (($pos = strpos($url, '?')) !== false) {
                $url = substr($url, 0, $pos);
            }
            
            // Trim trailing slashes for consistency
            $url = rtrim($url, '/');
            if (empty($url)) {
                $url = '/';
            }
        }

        $requestType = $_SERVER['REQUEST_METHOD'];

        // Debug routing information
        if (defined('DEBUG') && DEBUG) {
            // echo "<pre>Route: {$url} ({$requestType})</pre>";
        }

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
