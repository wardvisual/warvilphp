<?php

class Generator
{
    public static function generate($name)
    {
        echo "Generating $name...\n";

        // Implement your generation logic here

        echo "Generation complete.\n";
    }

    public static function anotherMethod()
    {
        echo "Running another method...\n";

        // Implement your logic for another method

        echo "Method complete.\n";
    }
}

// Check if at least one argument is provided
if ($argc < 2) {
    echo "Usage: php generate.php <method> [additional arguments]\n";
    exit(1);
}

// Get the method argument from the command line
$method = $argv[1];

// Call the specified method with additional arguments if needed
switch ($method) {
    case 'generate':
        if ($argc !== 3) {
            echo "Usage: php generate.php generate <name>\n";
            exit(1);
        }
        $name = $argv[2];
        Generator::generate($name);
        break;

    case 'anotherMethod':
        Generator::anotherMethod();
        break;

    default:
        echo "Unknown method: $method\n";
        exit(1);
}
