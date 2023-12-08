<?php 

use \app\core\Controller;
use \app\models\{User};

class Home extends Controller {
    public function index()
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }
}