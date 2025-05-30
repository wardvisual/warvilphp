<?php

function generateApiController($controllerName)
{
    $controllerName = ucfirst($controllerName);
    $lowerCaseControllerName = strtolower($controllerName);
    $controllerContent = <<<EOT
<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class {$controllerName}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        // Return list of resources
        Response::json([
            'success' => true,
            'data' => []
        ]);
    }

    /**
     * Store a newly created resource.
     *
     * @return void
     */
    public function store(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        try {
            // Validate request
            \$data = Request::validate([
                'name' => 'required|min:3',
                // Add validation rules for your fields
            ]);
    
            // Create resource
            // \$model = new YourModel();
            // \$model->create(\$data);
    
            Response::json([
                'success' => true,
                'message' => '{$controllerName} created successfully',
                'data' => \$data
            ], 201);
        } catch (\Exception \$e) {
            Response::status(400)->json([
                'success' => false,
                'message' => \$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function show(): void
    {
        \$id = Request::input('id');
        
        Response::json([
            'success' => true,
            'data' => ['id' => \$id]
        ]);
    }

    /**
     * Update the specified resource.
     *
     * @return void
     */
    public function update(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        \$id = Request::input('id');
        
        try {
            // Validate request
            \$data = Request::validate([
                'name' => 'required|min:3',
                // Add validation rules for your fields
            ]);
    
            Response::json([
                'success' => true,
                'message' => '{$controllerName} updated successfully'
            ]);
        } catch (\Exception \$e) {
            Response::status(400)->json([
                'success' => false,
                'message' => \$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource.
     *
     * @return void
     */
    public function destroy(): void
    {
        if (!Request::isPostMethod()) {
            Response::status(405)->json(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        \$id = Request::input('id');
        
        Response::json([
            'success' => true,
            'message' => '{$controllerName} deleted successfully'
        ]);
    }
}
EOT;

    file_put_contents("app/controllers/{$controllerName}Controller.php", $controllerContent);

    echo "API Controller {$controllerName}Controller.php has been created in the app/controllers directory.\n";
}

// Get the controller name from the terminal argument
$controllerName = $argv[1] ?? '';

if ($controllerName) {
    generateApiController($controllerName);
} else {
    echo "Please provide a controller name.\n";
}