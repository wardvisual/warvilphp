<?php

function generateComponent($componentName)
{
    // Format the component name and create path
    $parts = explode('/', $componentName);
    $name = array_pop($parts);
    $directory = "app/shared/components/" . implode('/', $parts);
    
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
    
    $componentContent = <<<EOT
<?php
function $name(\$data = [])
{
    // Extract data variables for easier access within the component
    extract(\$data);
    
    // Begin component output
    ?>
    <div class="$name-component">
        <!-- 
         * Component: $name
         * Usage: <?php $name(['key' => 'value']); ?>
         -->
        <div class="component-content">
            <!-- Your component content here -->
            <?php if (isset(\$title)): ?>
                <h3><?= \$title ?></h3>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
EOT;

    file_put_contents("$directory/$name.php", $componentContent);

    echo "Component $name.php has been created in the $directory directory.\n";
}

// Get the component name from the terminal argument
$componentName = $argv[1] ?? '';

if ($componentName) {
    generateComponent($componentName);
} else {
    echo "Please provide a component name (e.g., 'buttons/primary' or 'card').\n";
}