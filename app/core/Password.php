<?php

namespace app\core;

class Password
{
    public static function hash($password)
    {
        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            array(
                'cost' => Config::get('password/cost'),
            )
        );
    }

    public static function rehash($hash)
    {
        // return password_rehash($hash, PASSWORD_BCRYPT, Config::get('password/cost'));
    }

    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function getInfo($hash)
    {
        return password_get_info($hash);
    }
}
