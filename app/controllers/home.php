<?php

use \app\core\{Controller, Request, Response};
use \app\models\User;

class Home extends Controller
{
    /**
     * Constructor to set CORS headers.
     */
    public function __construct()
    {
        // Allow cross-origin requests from any origin
        header('Access-Control-Allow-Origin: *');
        // Allow only specified methods for cross-origin requests
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        // Allow the Content-Type header for cross-origin requests
        header('Access-Control-Allow-Headers: Content-Type');
    }

    /**
     * Display the index page.
     */
    public function index(): void
    {
        $payload = [
            'users' => User::getUsers()
        ];

        $this->view('home/index', $payload);
    }

    /**
     * Handle the user creation request.
     */
    public function store(): void
    {
        // Check if the request method is POST
        if (Request::isPostMethod()) {
            $userData = [
                'name' => Request::input('name'),
            ];

            // Attempt to create a new user
            $userCreated = User::create($userData);

            // Check if user creation failed
            if (!$userCreated) {
                Response::status(500)->json(['status' => 'error', 'message' => 'User creation failed']);
            }

            // Respond with success status if user created successfully
            Response::status(201)->json(['status' => 'success', 'message' => 'User created successfully']);
        } else {
            // Respond with error status for invalid request method
            Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);
        }

        // Exit the script after responding
        exit();
    }
}
