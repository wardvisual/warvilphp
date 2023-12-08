<?php 

class Home extends Controller {
    public function index()
    {
        // $user = $this->model('User')->getUser();
        // $user->name = 'Edward';
        $this->view('home/index', ['age' => 32]);
    }
}