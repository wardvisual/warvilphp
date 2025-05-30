<?php

define('WARVIL_START', microtime(true));
define('WARVIL_VERSION', '1.0.0');
define('WARVIL_ROOT', dirname(__DIR__));

// Check if Composer's autoloader exists
if (file_exists(WARVIL_ROOT . '/vendor/autoload.php')) {
    // Use Composer's autoloader
    require_once WARVIL_ROOT . '/vendor/autoload.php';
} else {
    // Fallback to manual autoloader
    require_once WARVIL_ROOT . '/app/init.php';
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Setting error reporting
if ((bool)getenv('APP_DEBUG') === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Define the BASE_URL constant
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = $basePath === '/' ? '' : $basePath;
define('BASE_URL', $protocol . '://' . $host . $basePath);

// Load configuration
if (!class_exists('\app\core\Config')) {
    require_once WARVIL_ROOT . '/app/core/Config.php';
}

// Allow cross-origin requests from any origin
header('Access-Control-Allow-Origin: *');
// Allow only specified methods for cross-origin requests
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Allow the Content-Type header for cross-origin requests
header('Access-Control-Allow-Headers: Content-Type');

// Return the app instance
return new \app\core\App();
