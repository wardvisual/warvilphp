<?php

// Get the file name from the terminal argument
$fileName = $argv[1] ?? '';

if ($fileName) {
    // Construct the file path
    $filePath = __DIR__ . "/$fileName.php";

    // Check if the file exists
    if (file_exists($filePath)) {
        // Execute the file
        require $filePath;
    } else {
        echo "The file $fileName.php does not exist in the current directory.\n";
    }
} else {
    echo "Please provide a file name.\n";
}
