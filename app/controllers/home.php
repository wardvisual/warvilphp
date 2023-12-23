<?php

use \app\core\{Controller, Request, Response, Storage};
use \app\models\User;

class Home extends Controller
{
    protected $data = [
        'users' => []
    ];

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

        $this->getUsers();
    }

    /**
     * Display the index page.
     */
    public function index(): void
    {
        $this->view('home/index', $this->data);
    }

    public function getUsers(): void
    {
        $user = new User();

        $this->data['users'] = $user->getAll();
    }

    /**
     * Handle the user creation request.
     */

    public function store(): void
    {
        // Check if the request method is POST
        if (Request::isPostMethod()) {
            $result =  Storage::upload(Request::file('image'));

            Response::status(201)->json(['status' => 'success', 'message' => $result]);
        } else {
            // Respond with error status for invalid request method
            Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);
        }

        // Exit the script after responding
        exit();
    }
    /**
     * Handle the user creation request.
     */

    // public function store(): void
    // {
    //     // Check if the request method is POST
    //     if (Request::isPostMethod()) {
    //         // Request::body(['name' => 'required|string']);
    //         $userData = [
    //             'name' => Request::input('name'),
    //         ];

    //         $user = new User();

    //         // Attempt to create a new user
    //         $userCreated =   $user->create($userData);

    //         // Check if user creation failed
    //         if (!$userCreated) {
    //             Response::status(500)->json(['status' => 'error', 'message' => 'User creation failed']);
    //         }

    //         Response::status(201)->json(['status' => 'success', 'message' => 'User created successfully']);
    //     } else {
    //         // Respond with error status for invalid request method
    //         Response::status(405)->json(['status' => 'error', 'message' => 'Invalid request method']);
    //     }

    //     // Exit the script after responding
    //     exit();
    // }
}