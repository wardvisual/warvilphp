<?php

/**
 * Controller Generator
 * Generates a controller with basic CRUD method templates and adds routes
 */
function generateController($controllerName)
{
    $controllerName = ucfirst($controllerName);
    // Strip 'Controller' suffix if it exists
    if (str_ends_with($controllerName, 'Controller')) {
        $baseName = substr($controllerName, 0, -10);
    } else {
        $baseName = $controllerName;
        $controllerName = $baseName . 'Controller';
    }
    
    $lowerCaseBaseName = strtolower($baseName);

    $controllerContent = <<<EOT
<?php

namespace app\\controllers;

use app\\core\\Controller;
use app\\core\\Request;
use app\\core\\Response;

class {$controllerName} extends Controller
{
    /**
     * Display a listing of the resources
     * 
     * @return void
     */
    public function index(): void
    {
        // Dummy data for demonstration
        \$items = [
            ['id' => 1, 'name' => 'Item 1', 'description' => 'Description for item 1'],
            ['id' => 2, 'name' => 'Item 2', 'description' => 'Description for item 2'],
            ['id' => 3, 'name' => 'Item 3', 'description' => 'Description for item 3'],
        ];
        
        \$this->view('{$lowerCaseBaseName}/index', [
            'items' => \$items,
            'title' => '{$baseName} Management'
        ]);
    }

    /**
     * Display the form for creating a new resource
     * 
     * @return void
     */
    public function create(): void
    {
        \$this->view('{$lowerCaseBaseName}/create', [
            'title' => 'Create New {$baseName}'
        ]);
    }

    /**
     * Store a newly created resource
     * 
     * @return void
     */
    public function store(): void
    {
        if (!Request::isPostMethod()) {
            \$this->view('errors/405');
            return;
        }
        
        // Get form data
        \$data = \$_POST;
        
        // Process the form submission
        // TODO: Add your store logic here
        
        // Redirect to index page
        header("Location: /{$lowerCaseBaseName}");
        exit;
    }

    /**
     * Display the specified resource
     * 
     * @return void
     */
    public function show(): void
    {
        \$id = Request::input('id');
        
        // Dummy item for demonstration
        \$item = [
            'id' => \$id,
            'name' => 'Sample {$baseName}',
            'description' => 'This is a sample {$baseName} with ID ' . \$id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        \$this->view('{$lowerCaseBaseName}/show', [
            'item' => \$item,
            'title' => '{$baseName} Details'
        ]);
    }

    /**
     * Display the form for editing the resource
     * 
     * @return void
     */
    public function edit(): void
    {
        \$id = Request::input('id');
        
        // Dummy item for demonstration
        \$item = [
            'id' => \$id,
            'name' => 'Sample {$baseName}',
            'description' => 'This is a sample {$baseName} with ID ' . \$id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        \$this->view('{$lowerCaseBaseName}/edit', [
            'item' => \$item,
            'title' => 'Edit {$baseName}'
        ]);
    }

    /**
     * Update the specified resource
     * 
     * @return void
     */
    public function update(): void
    {
        if (!Request::isPostMethod()) {
            \$this->view('errors/405');
            return;
        }
        
        \$id = Request::input('id');
        
        // Get form data
        \$data = \$_POST;
        
        // Process the form submission
        // TODO: Add your update logic here
        
        // Redirect to show page
        header("Location: /{$lowerCaseBaseName}/show?id={\$id}");
        exit;
    }

    /**
     * Remove the specified resource
     * 
     * @return void
     */
    public function destroy(): void
    {
        if (!Request::isPostMethod()) {
            \$this->view('errors/405');
            return;
        }
        
        \$id = Request::input('id');
        
        // Process the deletion
        // TODO: Add your delete logic here
        
        // Redirect to index page
        header("Location: /{$lowerCaseBaseName}");
        exit;
    }
}
EOT;

    // Create directories if they don't exist
    if (!is_dir("app/controllers")) {
        mkdir("app/controllers", 0755, true);
    }
    
    // Create controller file
    file_put_contents("app/controllers/{$controllerName}.php", $controllerContent);
    echo "{$controllerName} has been created in app/controllers directory.\n";
    
    // Create view directory and files for this controller
    createViewsForController($baseName, $lowerCaseBaseName);
    
    // Ensure error views exist
    createErrorViews();
    
    // Add routes for this controller
    addWebRoutes($baseName, $controllerName, $lowerCaseBaseName);
    
    echo "Controller generation completed successfully.\n";
}

/**
 * Add web routes for the controller
 */
function addWebRoutes($baseName, $controllerName, $lowerBaseName) {
    $routeFile = "app/routes/web.php";
    
    if (file_exists($routeFile)) {
        $content = file_get_contents($routeFile);
        
        // Check if route import exists
        if (strpos($content, 'use app\core\{Router}') === false) {
            $content = "<?php\n\nuse app\core\{Router};\n\n" . $content;
        }
        
        // Check if the routes already exist
        if (strpos($content, "Router::resource('{$lowerBaseName}'") === false) {
            // Check if Router::resource method exists or we need to add individual routes
            if (strpos($content, 'Router::resource') !== false) {
                // Router::resource exists, use it
                $routeContent = "\n// {$baseName} routes\nRouter::resource('{$lowerBaseName}', '{$controllerName}');\n";
            } else {
                // Add individual routes
                $routeContent = <<<EOT

// {$baseName} routes
Router::get('/{$lowerBaseName}', '{$controllerName}', 'index');
Router::get('/{$lowerBaseName}/create', '{$controllerName}', 'create');
Router::post('/{$lowerBaseName}/store', '{$controllerName}', 'store');
Router::get('/{$lowerBaseName}/show', '{$controllerName}', 'show');
Router::get('/{$lowerBaseName}/edit', '{$controllerName}', 'edit');
Router::post('/{$lowerBaseName}/update', '{$controllerName}', 'update');
Router::post('/{$lowerBaseName}/destroy', '{$controllerName}', 'destroy');
EOT;
            }
            
            // Add routes before the last closing tag or at the end
            $content = preg_replace('/(\\?>\\s*$)/', $routeContent . "\n$1", $content, 1, $count);
            if ($count === 0) {
                $content .= $routeContent . "\n";
            }
            
            file_put_contents($routeFile, $content);
            echo "Routes added to {$routeFile}\n";
            
            // Add resource method to Router class if it doesn't exist
            addResourceMethodToRouter();
        } else {
            echo "Routes for {$baseName} already exist in {$routeFile}\n";
        }
    } else {
        // Create the file
        $fileContent = <<<EOT
<?php

use app\core\{Router};

// {$baseName} routes
Router::get('/{$lowerBaseName}', '{$controllerName}', 'index');
Router::get('/{$lowerBaseName}/create', '{$controllerName}', 'create');
Router::post('/{$lowerBaseName}/store', '{$controllerName}', 'store');
Router::get('/{$lowerBaseName}/show', '{$controllerName}', 'show');
Router::get('/{$lowerBaseName}/edit', '{$controllerName}', 'edit');
Router::post('/{$lowerBaseName}/update', '{$controllerName}', 'update');
Router::post('/{$lowerBaseName}/destroy', '{$controllerName}', 'destroy');

EOT;

        file_put_contents($routeFile, $fileContent);
        echo "Created {$routeFile} with routes for {$baseName}\n";
    }
}

/**
 * Add resource method to Router class if it doesn't exist
 */
function addResourceMethodToRouter() {
    $routerFile = "app/core/Router.php";
    
    if (file_exists($routerFile)) {
        $content = file_get_contents($routerFile);
        
        // Check if resource method already exists
        if (strpos($content, 'public static function resource') === false) {
            // Find the class closure
            $pattern = '/class\s+Router\s*\{(.*?)}/s';
            preg_match($pattern, $content, $matches);
            
            if (isset($matches[1])) {
                // Add resource method to the Router class
                $resourceMethod = <<<'EOT'

    /**
     * Register resource routes for a controller
     *
     * @param string $name
     * @param string $controller
     * @return void
     */
    public static function resource($name, $controller)
    {
        self::get('/' . $name, $controller, 'index');
        self::get('/' . $name . '/create', $controller, 'create');
        self::post('/' . $name . '/store', $controller, 'store');
        self::get('/' . $name . '/show', $controller, 'show');
        self::get('/' . $name . '/edit', $controller, 'edit');
        self::post('/' . $name . '/update', $controller, 'update');
        self::post('/' . $name . '/destroy', $controller, 'destroy');
    }
EOT;

                // Insert the resource method before the last closing brace
                $updatedClassContent = preg_replace('/}\s*$/', $resourceMethod . "\n}", $content);
                file_put_contents($routerFile, $updatedClassContent);
                echo "Added 'resource' method to Router class.\n";
            }
        }
    }
}

function createViewsForController($controllerName, $lowerName) 
{
    $viewDir = "app/views/{$lowerName}";
    if (!is_dir($viewDir)) {
        mkdir($viewDir, 0755, true);
    }
    
    // Create index view
    $indexView = <<<EOT
<div class="container">
    <h1><?= \$title ?? '{$controllerName} List' ?></h1>
    
    <div class="actions">
        <a href="/{$lowerName}/create" class="btn">Create New {$controllerName}</a>
    </div>
    
    <div class="items-list">
        <?php if(empty(\$items)): ?>
            <p>No {$lowerName}s found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach(\$items as \$item): ?>
                        <tr>
                            <td><?= \$item['id'] ?></td>
                            <td><?= \$item['name'] ?? 'Unnamed' ?></td>
                            <td>
                                <a href="/{$lowerName}/show?id=<?= \$item['id'] ?>">View</a>
                                <a href="/{$lowerName}/edit?id=<?= \$item['id'] ?>">Edit</a>
                                <form action="/{$lowerName}/destroy" method="post" style="display: inline">
                                    <input type="hidden" name="id" value="<?= \$item['id'] ?>">
                                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
EOT;

    file_put_contents("{$viewDir}/index.php", $indexView);
    echo "Created view: {$viewDir}/index.php\n";
    
    // Create show view
    $showView = <<<EOT
<div class="container">
    <h1><?= \$title ?? '{$controllerName} Details' ?></h1>
    
    <div class="actions">
        <a href="/{$lowerName}" class="btn">Back to List</a>
        <a href="/{$lowerName}/edit?id=<?= \$item['id'] ?>" class="btn">Edit</a>
        <form action="/{$lowerName}/destroy" method="post" style="display: inline">
            <input type="hidden" name="id" value="<?= \$item['id'] ?>">
            <button type="submit" class="btn" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
    
    <div class="details">
        <p><strong>ID:</strong> <?= \$item['id'] ?></p>
        <p><strong>Name:</strong> <?= \$item['name'] ?? 'Unnamed' ?></p>
        <p><strong>Description:</strong> <?= \$item['description'] ?? 'No description' ?></p>
        <p><strong>Created:</strong> <?= \$item['created_at'] ?? 'Unknown' ?></p>
    </div>
</div>
EOT;

    file_put_contents("{$viewDir}/show.php", $showView);
    echo "Created view: {$viewDir}/show.php\n";
    
    // Create create view
    $createView = <<<EOT
<div class="container">
    <h1><?= \$title ?? 'Create New {$controllerName}' ?></h1>
    
    <?php if(isset(\$error)): ?>
        <div class="alert alert-danger">
            <?= \$error ?>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <a href="/{$lowerName}" class="btn">Back to List</a>
    </div>
    
    <form action="/{$lowerName}/store" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= \$data['name'] ?? '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= \$data['description'] ?? '' ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Create</button>
        </div>
    </form>
</div>
EOT;

    file_put_contents("{$viewDir}/create.php", $createView);
    echo "Created view: {$viewDir}/create.php\n";
    
    // Create edit view
    $editView = <<<EOT
<div class="container">
    <h1><?= \$title ?? 'Edit {$controllerName}' ?></h1>
    
    <?php if(isset(\$error)): ?>
        <div class="alert alert-danger">
            <?= \$error ?>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <a href="/{$lowerName}" class="btn">Back to List</a>
        <a href="/{$lowerName}/show?id=<?= \$item['id'] ?>" class="btn">Details</a>
    </div>
    
    <form action="/{$lowerName}/update" method="post">
        <input type="hidden" name="id" value="<?= \$item['id'] ?>">
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= \$data['name'] ?? \$item['name'] ?? '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= \$data['description'] ?? \$item['description'] ?? '' ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Save</button>
        </div>
    </form>
</div>
EOT;

    file_put_contents("{$viewDir}/edit.php", $editView);
    echo "Created view: {$viewDir}/edit.php\n";
}

function createErrorViews() 
{
    $errorDir = "app/views/errors";
    if (!is_dir($errorDir)) {
        mkdir($errorDir, 0755, true);
    }
    
    $errorViews = [
        "400" => "<h1>400 Bad Request</h1><p>The server could not understand the request due to invalid syntax.</p>",
        "404" => "<h1>404 Not Found</h1><p>The requested resource could not be found.</p>",
        "405" => "<h1>405 Method Not Allowed</h1><p>The request method is not supported for the requested resource.</p>",
        "500" => "<h1>500 Internal Server Error</h1><p>The server encountered an unexpected condition that prevented it from fulfilling the request.</p>"
    ];
    
    foreach ($errorViews as $code => $content) {
        if (!file_exists("{$errorDir}/{$code}.php")) {
            file_put_contents("{$errorDir}/{$code}.php", $content);
            echo "Created error view: {$errorDir}/{$code}.php\n";
        }
    }
}

// Get the controller name from the terminal argument
$controllerName = $argv[1] ?? '';

if ($controllerName) {
    generateController($controllerName);
} else {
    echo "Please provide a controller name.\n";
}