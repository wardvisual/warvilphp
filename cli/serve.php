<?php

/**
 * Start the PHP development server
 *
 * @param array $options Optional parameters [host, port]
 * @return void
 */
function startServer($options = [])
{
    $host = $options[0] ?? 'localhost';
    $port = $options[1] ?? '8000';

    $green = "\033[0;32m";
    $yellow = "\033[1;33m";
    $purple = "\033[0;35m";
    $reset = "\033[0m";

    echo "{$purple}
╦ ╦┌─┐┬─┐┬  ┬┬┬  ╔═╗╦ ╦╔═╗
║║║├─┤├┬┘└┐┌┘││  ╠═╝╠═╣╠═╝
╚╩╝┴ ┴┴└─ └┘ ┴┴─┘╩  ╩ ╩╩   
    {$reset}\n";

    echo "{$green}Starting WarvilPHP development server:{$reset}\n\n";
    echo "{$yellow}Server: http://{$host}:{$port}{$reset}\n";
    echo "{$green}Press Ctrl+C to stop the server{$reset}\n\n";

    // Check if server.php exists, if not create it
    if (!file_exists('server.php') || true) { // Always update the server.php file
        $serverContent = <<<'EOT'
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
EOT;
        file_put_contents('server.php', $serverContent);
        echo "Created server.php file for routing\n";
    }

    // Run the PHP development server
    passthru("php -S {$host}:{$port} server.php");
}

// Get command arguments
$host = $argv[1] ?? null;
$port = $argv[2] ?? null;

// Start the server
startServer([$host, $port]);