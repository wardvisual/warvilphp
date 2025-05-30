<?php
/* eslint-disable */
function generateView($viewName, $controllerName = null)
{
    // Format the view name and get controller if not provided
    if (!$controllerName) {
        // Extract controller name from view (e.g. "user/show" => "user")
        $parts = explode('/', $viewName);
        $controllerName = $parts[0];
    }
    
    // Create directory if it doesn't exist
    $directory = "app/views/" . strtolower($controllerName);
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    // Get view file name (e.g. "user/show" => "show")
    $viewFileName = basename($viewName);
    
    // Generate the view content
    $viewContent = <<<EOT
<div class="container">
    <h1><?= ucfirst("$viewFileName") ?></h1>
    <div class="content">
        <!-- Your view content here -->
    </div>
</div>
EOT;

    // Create the view file
    $viewPath = "$directory/$viewFileName.php";
    file_put_contents($viewPath, $viewContent);

    // Generate matching CSS file
    $cssContent = <<<EOT
/* 
 * Styles for $viewFileName view
 */
.container {
    padding: 20px;
}

.content {
    margin-top: 20px;
}
EOT;

    file_put_contents("$directory/$viewFileName.css", $cssContent);

    echo "View $viewPath and its CSS file have been created.\n";
}

// Get the view name from the terminal argument
$viewInfo = $argv[1] ?? '';

if ($viewInfo) {
    $parts = explode(':', $viewInfo);
    $viewName = $parts[0];
    $controllerName = $parts[1] ?? null;
    generateView($viewName, $controllerName);
} else {
    echo "Please provide a view name (e.g., 'user/index' or 'user/index:User').\n";
}