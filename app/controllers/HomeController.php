<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resources
     * 
     * @return void
     */
    public function index(): void
    {
        // Dummy data for demonstration
        $items = [
            ['id' => 1, 'name' => 'Item 1', 'description' => 'Description for item 1'],
            ['id' => 2, 'name' => 'Item 2', 'description' => 'Description for item 2'],
            ['id' => 3, 'name' => 'Item 3', 'description' => 'Description for item 3'],
        ];
        
        $this->view('home/index', [
            'items' => $items,
            'title' => 'Home Management'
        ]);
    }
    
    /**
     * Display the specified resource
     * 
     * @return void
     */
    public function show(): void
    {
        $id = Request::input('id');
        
        // Dummy item for demonstration
        $item = [
            'id' => $id,
            'name' => 'Sample Home',
            'description' => 'This is a sample Home with ID ' . $id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->view('home/show', [
            'item' => $item,
            'title' => 'Home Details'
        ]);
    }

    /**
     * Display the form for creating a new resource
     * 
     * @return void
     */
    public function create(): void
    {
        $this->view('home/create', [
            'title' => 'Create New Home'
        ]);
    }

    /**
     * Store a newly created resource
     * 
     * @return void
     */
    public function store(): void
    {
        if (!Request::isPostMethod()) {
            $this->view('errors/405');
            return;
        }
        
        // Get form data
        $data = $_POST;
        
        // Process the form submission
        // TODO: Add your store logic here
        
        // Redirect to index page
        header("Location: /home");
        exit;
    }

    /**
     * Display the form for editing the resource
     * 
     * @return void
     */
    public function edit(): void
    {
        $id = Request::input('id');
        
        // Dummy item for demonstration
        $item = [
            'id' => $id,
            'name' => 'Sample Home',
            'description' => 'This is a sample Home with ID ' . $id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->view('home/edit', [
            'item' => $item,
            'title' => 'Edit Home'
        ]);
    }

    /**
     * Update the specified resource
     * 
     * @return void
     */
    public function update(): void
    {
        if (!Request::isPostMethod()) {
            $this->view('errors/405');
            return;
        }
        
        $id = Request::input('id');
        
        // Get form data
        $data = $_POST;
        
        // Process the form submission
        // TODO: Add your update logic here
        
        // Redirect to show page
        header("Location: /home/show?id={$id}");
        exit;
    }

    /**
     * Remove the specified resource
     * 
     * @return void
     */
    public function destroy(): void
    {
        if (!Request::isPostMethod()) {
            $this->view('errors/405');
            return;
        }
        
        $id = Request::input('id');
        
        // Process the deletion
        // TODO: Add your delete logic here
        
        // Redirect to index page
        header("Location: /home");
        exit;
    }
}