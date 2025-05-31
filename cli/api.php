<?php

/**
 * API Controller Generator
 * Generates a RESTful API controller with simple responses and routes
 */
function generateApiController($controllerName)
{
    // Format the controller name
    if (str_ends_with($controllerName, 'Controller')) {
        $baseName = substr($controllerName, 0, -10);
        $controllerName = $baseName . 'Controller';
    } else {
        $baseName = $controllerName;
        $controllerName = $baseName . 'Controller';
    }
    
    $baseName = ucfirst($baseName);
    $controllerName = ucfirst($controllerName);
    $lowerBaseName = strtolower($baseName);
    
    $controllerContent = <<<EOT
<?php

namespace app\\controllers\\api;

use app\\core\\Controller;
use app\\core\\Request;
use app\\core\\Response;

class {$controllerName} extends Controller
{
    /**
     * Get all resources
     *
     * @return void
     */
    public function index(): void
    {
        // Return dummy data
        Response::json([
            'success' => true,
            'message' => 'Welcome to {$baseName} API',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Sample {$baseName} 1',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'name' => 'Sample {$baseName} 2',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'name' => 'Sample {$baseName} 3',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        ]);
    }

    /**
     * Get a single resource by ID
     *
     * @return void
     */
    public function show(): void
    {
        \$id = Request::input('id');
        
        if (!isset(\$id)) {
            Response::status(400)->json([
                'success' => false,
                'message' => 'ID is required'
            ]);
            return;
        }
        
        // Return dummy data for the specified ID
        Response::json([
            'success' => true,
            'data' => [
                'id' => \$id,
                'name' => 'Sample {$baseName} ' . \$id,
                'description' => 'This is a sample {$baseName} with ID ' . \$id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Create a new resource
     *
     * @return void
     */
    public function store(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json([
                'success' => false, 
                'message' => 'Method not allowed'
            ]);
            return;
        }
        
        try {
            // Get request data
            \$data = Request::body();
            
            // Return success response with the received data
            Response::status(201)->json([
                'success' => true,
                'message' => '{$baseName} created successfully',
                'data' => \$data,
                'id' => rand(1000, 9999) // Simulated ID
            ]);
            
        } catch (\Exception \$e) {
            Response::status(400)->json([
                'success' => false,
                'message' => \$e->getMessage()
            ]);
        }
    }

    /**
     * Update an existing resource
     *
     * @return void
     */
    public function update(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json([
                'success' => false, 
                'message' => 'Method not allowed'
            ]);
            return;
        }
        
        \$id = Request::input('id');
        
        if (!isset(\$id)) {
            Response::status(400)->json([
                'success' => false,
                'message' => 'ID is required'
            ]);
            return;
        }
        
        // Get request data
        \$data = Request::body();
        
        // Return success response
        Response::json([
            'success' => true,
            'message' => '{$baseName} updated successfully',
            'id' => \$id,
            'received_data' => \$data
        ]);
    }

    /**
     * Delete a resource
     *
     * @return void
     */
    public function destroy(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json([
                'success' => false, 
                'message' => 'Method not allowed'
            ]);
            return;
        }
        
        \$id = Request::input('id');
        
        if (!isset(\$id)) {
            Response::status(400)->json([
                'success' => false,
                'message' => 'ID is required'
            ]);
            return;
        }
        
        // Return success response
        Response::json([
            'success' => true,
            'message' => '{$baseName} deleted successfully',
            'id' => \$id
        ]);
    }
    
    /**
     * Get API information
     * 
     * @return void
     */
    public function info(): void
    {
        Response::json([
            'success' => true,
            'message' => 'Welcome to WarvilPHP API',
            'controller' => '{$controllerName}',
            'endpoints' => [
                'GET /api/{$lowerBaseName}' => 'List all {$lowerBaseName}s',
                'GET /api/{$lowerBaseName}/show?id=1' => 'Get {$lowerBaseName} with ID 1',
                'POST /api/{$lowerBaseName}/store' => 'Create a new {$lowerBaseName}',
                'POST /api/{$lowerBaseName}/update?id=1' => 'Update {$lowerBaseName} with ID 1',
                'POST /api/{$lowerBaseName}/destroy?id=1' => 'Delete {$lowerBaseName} with ID 1',
                'GET /api/{$lowerBaseName}/info' => 'Show this info'
            ],
            'version' => '1.0.0',
            'framework' => 'WarvilPHP'
        ]);
    }
}
EOT;

    // Ensure directories exist
    if (!is_dir("app/controllers/api")) {
        mkdir("app/controllers/api", 0755, true);
    }
    
    // Create API controller
    file_put_contents("app/controllers/api/{$controllerName}.php", $controllerContent);
    echo "API Controller {$controllerName} has been created in app/controllers/api/ directory.\n";
    
    // Add routes for this API controller
    addApiRoutes($baseName, $controllerName, $lowerBaseName);
    
    echo "API controller generation completed successfully.\n";
}

/**
 * Add API routes for the controller
 */
function addApiRoutes($modelName, $controllerName, $lowerModelName) {
    $routeFile = "app/routes/api.php";
    
    if (file_exists($routeFile)) {
        $content = file_get_contents($routeFile);
        
        // Check if route import exists
        if (strpos($content, 'use app\core\{RouterApi}') === false) {
            $content = "<?php\n\nuse app\core\{RouterApi};\n\n" . $content;
        }
        
        // Check if the routes already exist
        if (strpos($content, "RouterApi::resource('{$lowerModelName}'") === false && 
            strpos($content, "'api\\\\{$controllerName}'") === false) {
            
            // Check if RouterApi::resource method exists or we need to add individual routes
            if (strpos($content, 'RouterApi::resource') !== false) {
                // RouterApi::resource exists, use it
                $routeContent = "\n// {$modelName} routes\nRouterApi::resource('{$lowerModelName}', 'api\\\\{$controllerName}');\n";
            } else {
                // Add individual routes
                $routeContent = <<<EOT

// {$modelName} routes
RouterApi::get('/{$lowerModelName}', 'api\\{$controllerName}', 'index');
RouterApi::get('/{$lowerModelName}/show', 'api\\{$controllerName}', 'show');
RouterApi::post('/{$lowerModelName}/store', 'api\\{$controllerName}', 'store');
RouterApi::post('/{$lowerModelName}/update', 'api\\{$controllerName}', 'update');
RouterApi::post('/{$lowerModelName}/destroy', 'api\\{$controllerName}', 'destroy');
RouterApi::get('/{$lowerModelName}/info', 'api\\{$controllerName}', 'info');
EOT;
            }
            
            // Add routes before the last closing tag or at the end
            $content = preg_replace('/(\\?>\\s*$)/', $routeContent . "\n$1", $content, 1, $count);
            if ($count === 0) {
                $content .= $routeContent . "\n";
            }
            
            file_put_contents($routeFile, $content);
            echo "Routes added to {$routeFile}\n";
            
            // Add resource method to RouterApi class if it doesn't exist
            addResourceMethodToRouterApi();
        } else {
            echo "Routes for {$modelName} already exist in {$routeFile}\n";
        }
    } else {
        // Create the file
        $fileContent = <<<EOT
<?php

use app\core\{RouterApi};

// {$modelName} routes
RouterApi::get('/{$lowerModelName}', 'api\\{$controllerName}', 'index');
RouterApi::get('/{$lowerModelName}/show', 'api\\{$controllerName}', 'show');
RouterApi::post('/{$lowerModelName}/store', 'api\\{$controllerName}', 'store');
RouterApi::post('/{$lowerModelName}/update', 'api\\{$controllerName}', 'update');
RouterApi::post('/{$lowerModelName}/destroy', 'api\\{$controllerName}', 'destroy');
RouterApi::get('/{$lowerModelName}/info', 'api\\{$controllerName}', 'info');

EOT;

        file_put_contents($routeFile, $fileContent);
        echo "Created {$routeFile} with routes for {$modelName}\n";
    }
}

/**
 * Add resource method to RouterApi class if it doesn't exist
 */
function addResourceMethodToRouterApi() {
    $routerFile = "app/core/RouterApi.php";
    
    if (file_exists($routerFile)) {
        $content = file_get_contents($routerFile);
        
        // Check if resource method already exists
        if (strpos($content, 'public static function resource') === false) {
            // Find the class closure
            $pattern = '/class\s+RouterApi\s*\{(.*?)}/s';
            preg_match($pattern, $content, $matches);
            
            if (isset($matches[1])) {
                // Add resource method to the RouterApi class
                $resourceMethod = <<<'EOT'

    /**
     * Register resource routes for an API controller
     *
     * @param string $name
     * @param string $controller
     * @return void
     */
    public static function resource($name, $controller)
    {
        self::get('/' . $name, $controller, 'index');
        self::get('/' . $name . '/show', $controller, 'show');
        self::post('/' . $name . '/store', $controller, 'store');
        self::post('/' . $name . '/update', $controller, 'update');
        self::post('/' . $name . '/destroy', $controller, 'destroy');
        self::get('/' . $name . '/info', $controller, 'info');
    }
EOT;

                // Insert the resource method before the last closing brace
                $updatedClassContent = preg_replace('/}\s*$/', $resourceMethod . "\n}", $content);
                file_put_contents($routerFile, $updatedClassContent);
                echo "Added 'resource' method to RouterApi class.\n";
            }
        }
    }
}

// Get the controller name from the terminal argument
$controllerName = $argv[1] ?? '';

if ($controllerName) {
    generateApiController($controllerName);
} else {
    echo "Please provide a controller name.\n";
}