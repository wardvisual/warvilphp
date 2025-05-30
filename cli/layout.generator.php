<?php
 
function generateLayout($layoutName)
{
    $layoutName = strtolower($layoutName);
    $layoutContent = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <!-- title -->
    <title><?= htmlspecialchars(\$warvilConfig['name']) ?></title>

    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars(\$warvilConfig['description']) ?>">
    <meta name="author" content="<?= htmlspecialchars(\$warvilConfig['author']) ?>">
    <meta name="keywords" content="<?= implode(', ', \$warvilConfig['keywords']) ?>">
    
    <!-- styles -->
    <link rel="stylesheet" href="<?= htmlspecialchars(\$baseStyle) ?>">
    <?php echo \$cssPath ? '<link rel="stylesheet" href="' . htmlspecialchars(\$cssPath) . '">' : ''; ?>
    
    <!-- Custom styles for this layout -->
    <style>
        /* Add your layout-specific styles here */
        body {
            font-family: 'Arial', sans-serif;
        }
        
        header, footer {
            padding: 1rem;
        }
        
        main {
            min-height: 70vh;
            padding: 2rem;
        }
    </style>
</head>

<body>
    <header>
        <!-- Navigation or header content -->
        <h1>{$layoutName} Layout</h1>
        <nav>
            <!-- Navigation items -->
        </nav>
    </header>
    
    <main>
        <!-- Main content area -->
        <?= \$this->content ?>
    </main>
    
    <footer>
        <!-- Footer content -->
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(\$warvilConfig['name']) ?></p>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Add your layout-specific scripts here
    </script>
</body>
</html>
EOT;

    // Create layout directory if it doesn't exist
    if (!is_dir("app/shared/layouts")) {
        mkdir("app/shared/layouts", 0755, true);
    }

    file_put_contents("app/shared/layouts/$layoutName.php", $layoutContent);

    echo "Layout $layoutName.php has been created in the app/shared/layouts directory.\n";
}

// Get the layout name from the terminal argument
$layoutName = $argv[1] ?? '';

if ($layoutName) {
    generateLayout($layoutName);
} else {
    echo "Please provide a layout name.\n";
}