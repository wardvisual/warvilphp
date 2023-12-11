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

    public function index(): void
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }

    public function store(): void
    {
        if (Request::isPostMethod()) {
            $userData = [
                'name' => Request::input('name'),
            ];

            $userCreated = User::create($userData);

            if (!$userCreated) {
                Response::status(500)->json(['status' => 'error', 'message' => 'User creation failed']);
                return;
            }

            Response::status(201)->json(['status' => 'success', 'message' => 'User created successfully']);
        } else {
            Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);
        }

        exit();
    }
}
