<?php 

use \app\core\{Controller};
use \app\models\{User};

require_once 'app/models/User.php';

class Home extends Controller {
    public function index()
    {
        $this->view('home/index', ['data' => User::getUser()]);
    }

    private function getUsers()
    {
        $user = User::getUser();

        return $user;
    }
}