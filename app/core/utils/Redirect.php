<?php

namespace app\core\utils;

use app\core\utils\UrlHelper;
use app\core\{App};

class Redirect
{
    public static function to($location = null)
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include 'app/views/error/' . '404.php';
                        exit();
                        break;
                }
            }

            $newPath = '';

            if (App::isProduction()) {
                $newPath = UrlHelper::baseUrl() . '/' . $location . '.php';
            } else {
                $newPath = UrlHelper::baseUrl() . '/bridal-shop' . '/' . $location . '.php';
            }

            echo "<script type='text/javascript'>window.location.href = '" . $newPath . "';</script>";
            exit();
        }
    }
}
