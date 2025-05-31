<?php

/**
 * Resource Generator
 * Creates a complete resource package: controller, API controller, views, and routes
 */
function generateResource($resourceName)
{
    $resourceName = ucfirst($resourceName);
    $lowercaseResourceName = strtolower($resourceName);
    $pluralResourceName = $lowercaseResourceName . 's';

    echo "\n{$resourceName} Resource Generator\n";
    echo "========================\n\n";

    // Create directories if they don't exist
    $directories = [
        'app/controllers',
        'app/controllers/api',
        'app/views/' . $lowercaseResourceName,
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            if (mkdir($dir, 0755, true)) {
                echo "Created directory: {$dir}\n";
            } else {
                echo "Failed to create directory: {$dir}\n";
                return;
            }
        }
    }

    echo "\n1. Generating Web Controller & Views...\n";
    // Generate Web Controller
    require_once dirname(__FILE__) . '/controller.generator.php';
    generateController($resourceName);

    echo "\n2. Generating API Controller...\n";
    // Generate API Controller
    require_once dirname(__FILE__) . '/api.php';
    generateApiController($resourceName);

    // Generate Table Schema if needed
    if (file_exists(dirname(__FILE__) . '/table.php')) {
        echo "\n3. Generating Database Table Schema...\n";
        require_once dirname(__FILE__) . '/table.php';
        
        if (function_exists('generateTable')) {
            generateTable($resourceName);
            echo "\nRun 'php warvil migration:run {$resourceName}:up' to create the database table.\n";
        } else {
            echo "Warning: Table generator function not found.\n";
        }
    }

    echo "\n{$resourceName} resource has been generated successfully!\n";
    echo "====================================================\n\n";
    echo "Try these endpoints:\n";
    echo "- Web: http://localhost:8000/{$lowercaseResourceName}\n";
    echo "- API: http://localhost:8000/api/{$lowercaseResourceName}\n";
    echo "- API Info: http://localhost:8000/api/{$lowercaseResourceName}/info\n";
}

// Get the resource name from the terminal argument
$resourceName = $argv[1] ?? '';

if ($resourceName) {
    generateResource($resourceName);
} else {
    echo "Please provide a resource name.\n";
}