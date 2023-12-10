<?php

use \app\core\{Controller};
use \app\models\{User};

class Home extends Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    }

    public function index()
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $age = $_POST['age'];

            $payload = [
                'name' => $name,
                'age' => $age,
            ];

            $result = \app\models\User::createUser($payload);

            echo json_encode(['status' => 'success', 'message' => 'User created successfully', 'data' => $payload]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }

        exit();
    }
}
