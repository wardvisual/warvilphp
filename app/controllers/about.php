<?php

use \app\core\Controller;

class About extends Controller
{
    /**
     * Display the index page.
     */
    public function index(): void
    {
        $this->view('about/index');
    }
}
