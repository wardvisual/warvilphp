<?php

use \app\core\Controller;

class Product extends Controller
{

    /** 
     * Display the index page. 
     */
    public function index(): void
    {
        $this->view('Product/index');
    }
}
