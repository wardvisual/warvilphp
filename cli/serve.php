<?php

/**
 * Start the PHP development server and automatically open the browser
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

    // Ensure welcome page exists
    createWelcomePage();

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

    // Open browser (platform-specific)
    $url = "http://{$host}:{$port}";
    if (PHP_OS_FAMILY === 'Windows') {
        // Windows
        pclose(popen("start {$url}", "r"));
    } elseif (PHP_OS_FAMILY === 'Darwin') {
        // macOS
        exec("open {$url}");
    } elseif (PHP_OS_FAMILY === 'Linux') {
        // Linux
        exec("xdg-open {$url} > /dev/null 2>&1 &");
    }
    
    echo "{$green}Opening browser to {$url}{$reset}\n\n";

    // Run the PHP development server
    passthru("php -S {$host}:{$port} server.php");
}

/**
 * Create a WarvilPHP welcome page if it doesn't exist
 */
function createWelcomePage() {
    // Create welcome controller if it doesn't exist
    if (!is_dir('app/controllers')) {
        mkdir('app/controllers', 0755, true);
    }

    if (!file_exists('app/controllers/WelcomeController.php')) {
        $controllerContent = <<<'EOT'
<?php

namespace app\controllers;

use app\core\Controller;

class WelcomeController extends Controller
{
    public function index(): void
    {
        $this->view('welcome/index');
    }
}
EOT;
        file_put_contents('app/controllers/WelcomeController.php', $controllerContent);
        echo "Created WelcomeController.php\n";
    }

    // Create welcome view directory
    if (!is_dir('app/views/welcome')) {
        mkdir('app/views/welcome', 0755, true);
    }

    // Create welcome view if it doesn't exist
    if (!file_exists('app/views/welcome/index.php')) {
        createWelcomeView();
    }

    // Update routes to include welcome route
    if (file_exists('app/routes/web.php')) {
        $routesContent = file_get_contents('app/routes/web.php');
        if (strpos($routesContent, 'WelcomeController') === false) {
            $updatedRoutes = preg_replace('/Router::get\(\'\\/\',.*?;/', "Router::get('/', 'WelcomeController', 'index');", $routesContent);
            file_put_contents('app/routes/web.php', $updatedRoutes);
            echo "Updated root route to use WelcomeController\n";
        }
    }

    // Make sure Tailwind is available
    ensureTailwindAvailable();
}

/**
 * Create Tailwind-styled welcome view
 */
function createWelcomeView() {
    $welcomeView = <<<'EOT'
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 flex items-center justify-center">
    <div class="w-full max-w-6xl bg-gray-900 bg-opacity-80 rounded-xl shadow-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-purple-400 text-6xl md:text-7xl lg:text-8xl font-bold mb-4">WarvilPHP</h1>
                <p class="text-gray-300 text-2xl md:text-3xl font-light">
                    The elegance of frameworks, the freedom of pure PHP.
                </p>
            </div>
            
            <!-- Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🏗️</div>
                    <h3 class="text-white text-xl font-semibold mb-2">MVC Architecture</h3>
                    <p class="text-gray-300">Clean separation of Model, View and Controller for organized code structure.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🌐</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Simple Routing</h3>
                    <p class="text-gray-300">Intuitive routing system for both web pages and API endpoints.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🔧</div>
                    <h3 class="text-white text-xl font-semibold mb-2">CLI Tools</h3>
                    <p class="text-gray-300">Built-in command line tools for scaffolding your application.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🧩</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Components</h3>
                    <p class="text-gray-300">Reusable view components for consistent interfaces.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🛡️</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Middleware</h3>
                    <p class="text-gray-300">Request filtering for authentication, validation, and more.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🔌</div>
                    <h3 class="text-white text-xl font-semibold mb-2">API Development</h3>
                    <p class="text-gray-300">Tools for building robust RESTful APIs quickly.</p>
                </div>
            </div>
            
            <!-- Get Started -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-lg mb-8">
                <h2 class="text-white text-2xl font-semibold mb-4">Get Started</h2>
                <div class="bg-gray-900 p-4 rounded-md overflow-x-auto mb-4">
                    <pre class="text-green-400">$ php warvil make:controller UserController</pre>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="/docs" class="block bg-purple-700 hover:bg-purple-600 text-white text-center py-3 px-4 rounded-md transition-colors">Documentation</a>
                    <a href="https://github.com/wardvisual/warvilphp" target="_blank" class="block bg-gray-700 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-md transition-colors">GitHub</a>
                    <a href="/examples" class="block bg-gray-700 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-md transition-colors">Examples</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center text-gray-400">
                <p>WarvilPHP v<?= WARVIL_VERSION ?? '1.0.0' ?> • Made with ❤️ by <a href="https://github.com/wardvisual" class="text-purple-400 hover:text-purple-300">WardVisual</a></p>
                <p class="text-sm mt-2">Under active development. While we strive for stability, use in production is at your own risk.</p>
            </div>
        </div>
    </div>
</div>
EOT;
    file_put_contents('app/views/welcome/index.php', $welcomeView);
    
    // Create CSS file for the welcome view
    if (!is_dir('app/views/welcome')) {
        mkdir('app/views/welcome', 0755, true);
    }
    
    $welcomeCSS = <<<'EOT'
/* Welcome page custom styles */
body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
EOT;
    file_put_contents('app/views/welcome/index.css', $welcomeCSS);
    echo "Created welcome view and styles\n";
}

/**
 * Ensure Tailwind CSS is available
 */
function ensureTailwindAvailable() {
    if (!is_dir('public/assets')) {
        mkdir('public/assets', 0755, true);
    }
    
    // Create a layout that includes Tailwind CDN
    if (!is_dir('app/shared/layouts')) {
        mkdir('app/shared/layouts', 0755, true);
    }
    
    if (!file_exists('app/shared/layouts/welcome.php')) {
        $layoutContent = <<<'EOT'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($warvilConfig['name'] ?? 'WarvilPHP') ?></title>
    
    <!-- Meta -->
    <meta name="description" content="<?= htmlspecialchars($warvilConfig['description'] ?? 'A lightweight PHP framework') ?>">
    <meta name="author" content="<?= htmlspecialchars($warvilConfig['author'] ?? 'WardVisual') ?>">
    
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?= htmlspecialchars($baseStyle ?? '') ?>">
    <?php echo isset($cssPath) && $cssPath ? '<link rel="stylesheet" href="' . htmlspecialchars($cssPath) . '">' : ''; ?>
    
    <style>
        /* Pulse animation for the logo */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <?= $this->content ?? '' ?>
    
    <!-- Optional JavaScript -->
    <script>
        // Add any JavaScript needed for the welcome page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('WarvilPHP - Welcome!');
        });
    </script>
</body>
</html>
EOT;
        file_put_contents('app/shared/layouts/welcome.php', $layoutContent);
        echo "Created welcome layout with Tailwind CSS\n";
    }
    
    // Update WelcomeController to use the welcome layout
    if (file_exists('app/controllers/WelcomeController.php')) {
        $controllerContent = file_get_contents('app/controllers/WelcomeController.php');
        if (strpos($controllerContent, 'layout') === false) {
            $updatedController = str_replace(
                '$this->view(\'welcome/index\');', 
                '$this->view(\'welcome/index\', [], [\'layout\' => \'welcome\']);', 
                $controllerContent
            );
            file_put_contents('app/controllers/WelcomeController.php', $updatedController);
        }
    }
}

// Get command arguments
$host = $argv[1] ?? null;
$port = $argv[2] ?? null;

// Start the server
startServer([$host, $port]);