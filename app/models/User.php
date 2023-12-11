<?php

namespace app\models;

use app\core\Model;

class User
{
    public static function user()
    {
        return new Model('users');
    }

    public static function getUsers(): array
    {
        return [];
    }

    public static function create($user = array()): bool
    {
        $userModel = self::user();
        return $userModel->create($user);
    }
}
