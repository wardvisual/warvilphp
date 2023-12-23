<?php

function displayHelp()
{
    echo "\033[1;33m\nWarvilPHP Framework\n\n\033[0m";
    echo "\033[1;32mphp cli/migration.php Class:up\033[0m - run a clean migration\n";
    echo "\033[1;32mphp cli/controller.php ClassName\033[0m - create a controller\n";
    echo "\n";
}

// Check if 'help' was passed as a CLI argument
if (in_array('help', $argv)) {
    displayHelp();
}
