<?php 

namespace app\models;

class User {
    private static string $name = 'Warvil';

    public static function getUser(): string
    {
        return self::$name;
    }
}