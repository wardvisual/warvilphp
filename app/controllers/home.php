<?php

use \app\core\{Controller, Request, Response, Storage};
use \app\models\User;

class Home extends Controller
{
    protected $data = [
        'users' => []
    ];

    public function __construct()
    {
        $user = new User();

        $this->data['users'] = $user->all();
    }

    public function index(): void
    {
        $this->component('card/index', ['users' => $this->data['users']]);
        $this->view('home/index', $this->data);
    }

    public function getData()
    {
        $user = new User();

        $user->all();
        return Response::json($this->data['users']);
    }

    public function store(): void
    {
        if (!Request::isPostMethod()) Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);

        $userData = [
            'username' => Request::input('username'),
            'email' => Request::input('email'),
        ];

        $user = new User();

        $userCreated = $user->create($userData);

        if (!$userCreated) Response::status(500)->json(['status' => 'error', 'message' => 'User creation failed']);

        Response::status(201)->json(['status' => 'success', 'message' => 'User created successfully']);
    }
    public function delete(): void
    {
        if (!Request::isPostMethod()) Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);

        $user = new User();

        $userCreated = $user->delete(Request::input('id'));

        if (!$userCreated) Response::status(500)->json(['status' => 'error', 'message' => 'User deletion failed']);

        Response::status(201)->json(['status' => 'success', 'message' => 'User deleted successfully']);
    }
}