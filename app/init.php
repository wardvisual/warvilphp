<?php
// filepath: c:\xampp\htdocs\warvilphp\app\init.php

require_once 'core/utils/Loader.php';

use app\core\utils\Loader;

// Allow cross-origin requests from any origin
header('Access-Control-Allow-Origin: *');
// Allow only specified methods for cross-origin requests
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
// Allow the Content-Type header for cross-origin requests
header('Access-Control-Allow-Headers: Content-Type');

spl_autoload_register(function ($class_name) {
    $core = ['App', 'Router', 'RouterApi', 'Controller', 'Model', 'Response', 'Request', 'Database', 'Config', 'Layout', 'Storage', 'Env'];
    $coreUtils = ['Loader', 'Helpers', 'DateHelper', 'UrlHelper', 'Redirect', 'Session'];
    $traits = ['Product'];

    // Load route files - ensure they exist first
    $routeFiles = ['web', 'api'];
    foreach ($routeFiles as $route) {
        $routePath = 'app/routes/' . $route . '.php';
        if (file_exists($routePath)) {
            require_once $routePath;
        } else {
            if (!is_dir('app/routes')) {
                mkdir('app/routes', 0755, true);
            }
            
            // Create a default route file
            if ($route === 'web') {
                $content = "<?php\n\nuse app\core\{Router};\n\nRouter::get('/', 'WelcomeController', 'index');\n";
                file_put_contents($routePath, $content);
                require_once $routePath;
            } else if ($route === 'api') {
                $content = "<?php\n\nuse app\core\{RouterApi};\n\n// API Routes\n";
                file_put_contents($routePath, $content);
                require_once $routePath;
            }
        }
    }

    foreach ($traits as $trait) {
        Loader::load('app/traits/', $trait);
    }

    foreach ($core as $class) {
        Loader::load('app/core/', $class);
    }

    foreach ($coreUtils as $class) {
        Loader::load('app/core/utils/', $class);
    }
});