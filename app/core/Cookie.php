<?php

namespace app\core;

class Cookie
{
    public static function exists($name)
    {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry)
    {
        if (setcookie($name, $value, time() + $expiry, '/')) {

            return true;
        }

        return false;
    }

    public static function delete($name)
    {
        // unset($_COOKIE[$name]);
        setcookie($name, '', time() - 3600, '/');
    }
}
