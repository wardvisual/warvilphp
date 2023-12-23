<?php

namespace app\core;

class Controller
{
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [], $options = [])
    {

        // require_once 'app/views/' . $view . '.php';
        $this->renderView('app/views/' . $view . '.php', $data, $options);
    }

    private function renderView($viewPath, $data = [], $options = null)
    {
        $layoutPath = !isset($options['layout']) ? Config::get('paths/layouts/default') : Config::get('paths/layouts/' . $options['layout']);

        // Get the path without the extension
        $pathWithoutExtension = pathinfo($viewPath, PATHINFO_DIRNAME) . '/' . pathinfo($viewPath, PATHINFO_FILENAME);

        // Append .css to the path
        $cssExist = $pathWithoutExtension . '.css';
        $cssPath = '';

        if (file_exists($cssExist)) {
            $cssPath = $cssExist;
        }

        ob_start();
        extract($data);
        include_once $viewPath;
        $content = ob_get_clean();

        $layout = new Layout($content);
        $layout->render($layoutPath, $cssPath);
    }
}