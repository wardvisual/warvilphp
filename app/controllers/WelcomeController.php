<?php

namespace app\controllers;

use app\core\Controller;

class WelcomeController extends Controller
{
    public function index(): void
    {
        // Change this line to use 'welcome' layout instead of 'app'
        $this->view('welcome/index', [], ['layout' => 'welcome']);
    }
}