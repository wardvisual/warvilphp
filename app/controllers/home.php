<?php

use \app\core\{Controller};
use \app\models\{User};

class Home extends Controller
{

    public function index()
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }

    public function store()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

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
            // Handle invalid request method (optional)
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }

        exit(); // Ensure nothing else is sent in the response
    }


    // create store logic
    // public function store()
    // {
    //     $payload = [
    //         'name' => 'haha',
    //         'age' => 32,
    //     ];

    //     User::createUser($payload);

    //     header('Location: /');
    // }
}
