<?php

namespace app\core;

class Controller
{
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {

        $this->renderView('app/views/' . $view . '.php', $data);
        // require_once 'app/views/' . $view . '.php';
    }

    private function renderView($viewPath, $data = [])
    {
        $layoutPath = Config::get('paths/layouts/default');

        ob_start();
        extract($data);
        include_once $viewPath;
        $content = ob_get_clean();

        $layout = new Layout($content);
        $layout->render($layoutPath);
    }
}
