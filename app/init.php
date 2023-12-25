<?php

require_once 'core/utils/Loader.php';

use app\core\utils\Loader;

// Allow cross-origin requests from any origin
header('Access-Control-Allow-Origin: *');
// Allow only specified methods for cross-origin requests
header('Access-Control-Allow-Methods: POST, OPTIONS');
// Allow the Content-Type header for cross-origin requests
header('Access-Control-Allow-Headers: Content-Type');

spl_autoload_register(function ($class_name) {
    $core = ['App', 'Controller', 'Model', 'Response', 'Request', 'Database', 'Config', 'Layout', 'Storage'];
    $coreUtils = ['Loader', 'Helpers', 'DateHelper'];

    foreach ($core as $class) {
        Loader::load('app/core/', $class);
    }

    foreach ($coreUtils as $class) {
        Loader::load('app/core/utils', $class);
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
