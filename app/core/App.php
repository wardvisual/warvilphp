<?php 

namespace app\core;

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $this->controller = strtolower($this->controller);

        try {
            $url = $this->parseURL();
    
            $this->setController($url);
            $this->setMethod($url);
            $this->setParams($url);

            call_user_func_array([$this->controller, $this->method], [$this->params]);
        } catch (\Exception $e) {
            echo '404 | Page not found.';
            // echo 'Page not found: <br/>next>> ' . $e->getMessage();
        }
    }

    private function setController(&$url)
    {
        if (!$url) $url = [$this->controller];
    
        if (!file_exists('app/controllers/' . $url[0] . '.php'))
            throw new \Exception('Controller not found: ' . $url[0]);
    
        $this->controller = $url[0];
        unset($url[0]);
    
        require_once 'app/controllers/' . $this->controller . '.php';
    
        if (!class_exists($this->controller)) 
            throw new \Exception('Class does not exist: ' . $this->controller);
    
        $this->controller = new $this->controller;
    }


    private function setMethod(&$url)
    {
        if (!isset($url[1])) return;

        if (!method_exists($this->controller, $url[1]))
            throw new \Exception('Method not found: ' . $url[1]);

        $this->method = $url[1];
        unset($url[1]);
    }
    
    private function setParams($url)
    {
        $this->params = $url ? array_values($url) : [];
    }

    public function parseURL()
    {
        if(!isset($_GET['url'])) return;
    
        $url = rtrim($_GET['url'],'/');
        $url = filter_var($url,FILTER_SANITIZE_URL);
        $url = explode('/',$url);

        return $url;
    }
}

