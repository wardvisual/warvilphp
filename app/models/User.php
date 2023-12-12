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
        $userModel = self::user();

        $response = $userModel->get(1, 1);

        if (!$response) {
            return [];
        }

        return $response->results();
    }

    public static function create($user = array()): bool
    {
        $userModel = self::user();
        return $userModel->create($user);
    }
}
