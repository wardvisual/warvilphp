<?php

function runMigration($className, $direction)
{
    // Construct the file path
    $file = "app/database/sql/$className.php";

    // Check if the file exists
    if (!file_exists($file)) {
        echo "The file $file does not exist.\n";
        return;
    }

    // Include the file
    require_once $file;

    // Create a new instance of the class
    $migration = new $className;

    // Call the up or down method based on the CLI argument
    if (method_exists($migration, $direction)) {
        $migration->$direction();
    } else {
        echo "The method $direction does not exist in the class $className.\n";
    }
}

// Get the CLI argument
list($className, $direction) = explode(':', $argv[1]);

// Run the migration
runMigration($className, $direction);
