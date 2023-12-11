<?php

function getModelName($model)
{
    return basename(str_replace('\\', '/', $model));
}

spl_autoload_register(function ($class_name) {
    $file = 'models/' . getModelName($class_name) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});


require_once 'core/App.php';
require_once 'core/Controller.php';
