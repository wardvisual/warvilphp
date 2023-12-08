<?php 

class Utils {
    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}