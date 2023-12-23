<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }
}
