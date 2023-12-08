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
        [
            'name' => 'Gardo',
            'age' => 20
        ],
    ];

    public static function getUsers(): array
    {
        return self::$users;
    }
}