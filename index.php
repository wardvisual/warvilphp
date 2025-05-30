<?php

/**
 * WarvilPHP - A lightweight PHP framework inspired by Laravel
 *
 * @package  WarvilPHP
 * @author   Edward Fernandez <wardvisual@gmail.com>
 */

// Define the current directory
define('CURRENT_DIR', __DIR__);

// Load the bootstrap file
$app = require_once 'app/bootstrap.php';

// Run the application
// The App constructor is already handling the request in your current code

// function bootstrap()
// {
//     require_once 'app/init.php';
//     new \app\core\App();
// }

// bootstrap();