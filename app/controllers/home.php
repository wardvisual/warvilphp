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
        // Allow requests from any origin (you might want to restrict this in production)
        header('Access-Control-Allow-Origin: *');

        // Allow the following methods
        header('Access-Control-Allow-Methods: POST, OPTIONS');

        // Allow the following headers
        header('Access-Control-Allow-Headers: Content-Type');

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = file_get_contents('php://input');

            // Attempt to decode as JSON
            $jsonData = json_decode($input, true);

            $name = $_POST['name'];
            $age = $_POST['age'];

            $payload = [
                'name' => $name,
                'age' => $age,
            ];

            $result = \app\models\User::createUser($payload);

            echo json_encode(['status' => 'success', 'message' => 'User created successfully', 'data' => $_POST]);
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
