<?php

use \app\core\{Controller, Request, Response};
use \app\models\User;

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
        if (Request::method() === 'POST') {
            $userData = [
                'name' => Request::input('name'),
            ];

            $response = User::create($userData);

            $json = $response
                ? ['status' => 'success', 'message' => 'User created successfully']
                : ['status' => 'error', 'message' => 'User creation failed'];

            Response::json($json);
        } else {
            Response::json(['status' => 'error', 'message' => 'Invalid request method']);
        }

        exit();
    }
}
