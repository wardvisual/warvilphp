<?php

namespace app\core;

class Layout
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function render($layoutPath = null, $cssPath = '')
    {
        // Read warvil.json
        $jsonFile = file_exists('warvil.json') ? file_get_contents('warvil.json') : '{}';
        $warvilConfig = json_decode($jsonFile, true) ?: [];

        $baseStyle = Config::get('paths/styles/base');

        // Process the layout path correctly
        if ($layoutPath === null) {
            // Use default layout from config
            $layoutPath = Config::get('paths/layouts/default');
            
            // If still null, use a fallback path
            if ($layoutPath === null) {
                $layoutPath = 'app/shared/layouts/main.php';
            }
        } else if ($layoutPath === 'welcome') {
            // Handle 'welcome' layout string
            $layoutPath = 'app/shared/layouts/welcome.php';
        } else if (!str_contains($layoutPath, '/') && !str_contains($layoutPath, '\\')) {
            // If it's just a name without path separators, assume it's in the layouts directory
            $layoutPath = 'app/shared/layouts/' . $layoutPath . '.php';
        }
        
        // Debug information
        if (defined('DEBUG') && DEBUG) {
            echo "<!-- Using layout: {$layoutPath} -->\n";
        }

        if (file_exists($layoutPath)) {
            include_once $layoutPath;
        } else {
            // More helpful error message
            echo 'Error: Layout file not found: ' . $layoutPath;
            echo '<br>Please make sure the layout file exists or update the layout path in your configuration.';
            echo '<br>Available layouts: ';
            
            // List available layouts
            if (is_dir('app/shared/layouts')) {
                $layouts = glob('app/shared/layouts/*.php');
                echo implode(', ', array_map(function($path) {
                    return basename($path, '.php');
                }, $layouts));
            } else {
                echo 'No layouts directory found.';
            }
        }
    }
}