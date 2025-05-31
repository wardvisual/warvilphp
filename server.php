<?php

/**
 * WarvilPHP Development Server Router
 * This file routes all requests through the index.php file unless they are for static files
 */

// Define a constant to indicate we're in development mode
define('DEBUG', true);

// Parse URL to get the path
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Check if the request is for a static file
$publicPath = __DIR__ . '/public';
$filePath = $publicPath . $uri;

// If the file exists directly in the public directory, serve it
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false; // Let the PHP server handle the static file
}

// For all other requests, route through index.php
require_once __DIR__ . '/index.php';