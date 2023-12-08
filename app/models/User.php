<?php 

namespace app\models;

class User {
    private static array $users = [
        [
            'name' => 'Edward',
            'age' => 20
        ],
        [
            'name' => 'Hanah',
            'age' => 19
        ],
    ];

    public static function getUsers(): array
    {
        return self::$users;
    }
}