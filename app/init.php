<?php
session_start();

require_once 'core/utils/Loader.php';

use app\core\Session;
use app\core\utils\Loader;

spl_autoload_register(function ($class_name) {
    $core = ['App', 'Router', 'RouterApi', 'Controller', 'Model', 'Response', 'Request', 'Database', 'Config', 'Layout', 'Storage', 'Session'];
    $coreUtils = ['Loader', 'Helpers', 'DateHelper', 'UrlHelper', 'Factory', 'Pagination', 'Hash', 'Password', 'Toaster'];
    $traits = ['Product'];

    $routes = ['web', 'api'];

    // Load all classes in core/utils folder
    foreach ($coreUtils as $class) {
        Loader::load('app/core/utils', $class);
    }

    foreach ($routes as $route) {
        Loader::load('app/routes/', $route);
    }

    foreach ($traits as $trait) {
        Loader::load('app/traits/', $trait);
    }

    foreach ($core as $class) {
        Loader::load('app/core/', $class);
    }
    // end of all classes in core/utils folder

    // classes that needs to load separately
    $model = 'app/models/' . getClassName($class_name) . '.php';
    $helper = 'app/core/utils/' . $class_name . '.php';
    $core = 'app/core/' . $class_name . '.php';
    $controller = 'app/controllers/' . getClassName($class_name) . '.php';
    $middleware = 'app/middlewares/' . getClassName($class_name) . '.php';

    if (file_exists($model)) {
        require_once $model;
    }

    if (file_exists($helper)) {
        Loader::load('app/core/utils/', $class_name);
    }

    if (file_exists($core)) {
        Loader::load('app/core/', $class_name);
    }

    if (file_exists($middleware)) {
        Loader::load('app/middleware/', getClassName($class_name));
    }

    if (file_exists($controller)) {
        Loader::load('app/controllers/', getClassName($class_name));
    }
});


// save inputs in session
$excludeFields = ['password', 'password_confirmation'];

foreach ($_POST as $key => $value) {
    if (!in_array($key, $excludeFields)) {
        Session::put('old/' . $key, $value);
    }
}