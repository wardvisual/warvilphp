<?php

require_once 'core/utils/Loader.php';

use app\core\utils\Loader;

Loader::load('app/core/utils/', 'Helpers');
Loader::load('app/core/utils/', 'DateHelper');
Loader::load('app/', 'config');
Loader::load('app/core/', 'Config');
Loader::load('app/core/', 'Database');
Loader::load('app/core/', 'Request');
Loader::load('app/core/', 'Response');

spl_autoload_register(function ($class_name) {
    $core = ['App', 'Controller', 'Model'];

    foreach ($core as $class) {
        Loader::load('app/core/', $class);
    }

    $model = 'app/models/' . getModelName($class_name) . '.php';
    $helper = 'app/core/utils/' . $class_name . '.php';
    $core = 'app/core/' . $class_name . '.php';

    if (file_exists($model)) {
        require_once $model;
    }

    if (file_exists($helper)) {
        Loader::load('app/core/utils/', $class_name);
    }

    if (file_exists($core)) {
        Loader::load('app/core/', $class_name);
    }
});
