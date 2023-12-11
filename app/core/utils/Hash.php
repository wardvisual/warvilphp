<?php

namespace app\core\utils;

use app\core\Config;

class Hash
{
    public static function make($string)
    {
        return hash(Config::get('hash/algo_name'), $string . Hash::salt());
    }

    public static function salt()
    {
        // < 7.2.0 mcrypt_create_iv 
        return random_bytes(Config::get('hash/salt'));
    }

    public static function unique()
    {
        return self::make(uniqid());
    }
}
