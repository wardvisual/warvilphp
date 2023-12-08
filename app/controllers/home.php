<?php 

use \app\core\{Controller};
use \app\models\{User};

class Home extends Controller {

    public function index()
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }

    // create store logic
    public function store()
    {
        $payload = [
            'name' => 'haha',
            'age' => 32,
        ];

        User::createUser($payload);

        header('Location: /');
    }

}