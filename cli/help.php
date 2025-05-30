#!/usr/bin/env php
<?php

if (PHP_SAPI !== 'cli') {
    exit('This script can only be executed from the command line.');
}

/**
 * Display help information
 */
function displayHelp()
{
    echo "\033[1;33m\nWarvilPHP Framework\n\n\033[0m";
    echo "\033[1;32mDatabase Commands:\033[0m\n";
    echo "  \033[1;36mphp warvil migration:run Class:up\033[0m - Run a migration\n";
    echo "  \033[1;36mphp warvil migration:run Class:down\033[0m - Reverse a migration\n";
    echo "  \033[1;36mphp warvil make:table TableName\033[0m - Create a table schema\n";
    echo "\n\033[1;32mGenerator Commands:\033[0m\n";
    echo "  \033[1;36mphp warvil make:model ModelName\033[0m - Create a model\n";
    echo "  \033[1;36mphp warvil make:controller ControllerName\033[0m - Create a controller\n";
    echo "  \033[1;36mphp warvil make:view path/name:Controller\033[0m - Create a view\n";
    echo "  \033[1;36mphp warvil make:middleware MiddlewareName\033[0m - Create a middleware\n";
    echo "  \033[1;36mphp warvil make:component path/ComponentName\033[0m - Create a component\n";
    echo "  \033[1;36mphp warvil make:service ServiceName\033[0m - Create a service\n";
    echo "  \033[1;36mphp warvil make:api ControllerName\033[0m - Create an API controller\n";
    echo "  \033[1;36mphp warvil make:layout LayoutName\033[0m - Create a layout\n";
    echo "\n";
}

// Define the commands map
$commands = [
    'make:controller' => 'cli/controller.php',
    'make:model' => 'cli/model.php',
    'make:view' => 'cli/view.php',
    'make:middleware' => 'cli/middleware.php',
    'make:component' => 'cli/component.php',
    'make:service' => 'cli/service.php',
    'make:api' => 'cli/api.php',
    'make:layout' => 'cli/layout.php',
    'make:table' => 'cli/table.php',
    'migration:run' => 'cli/migration.php',
    'help' => null // Handle help internally
];

// Check if script was called directly
$isDirectCall = (basename($_SERVER['SCRIPT_FILENAME']) === 'help.php');

// Check if a command was provided or if this is the help command
if ($isDirectCall || $argc < 2 || (isset($argv[1]) && $argv[1] === 'help')) {
    displayHelp();
    exit(0);
}

$command = $argv[1];

// Check if the command exists
if (!isset($commands[$command])) {
    echo "Command '$command' not found.\n";
    echo "For available commands, use: php warvil help\n";
    exit(1);
}

// Exit if it's the help command (already handled)
if ($command === 'help') {
    exit(0);
}

// Build the arguments for the command
$commandArgs = array_slice($argv, 2);
$commandScript = $commands[$command];

// Execute the command
if (empty($commandArgs)) {
    echo "Please provide arguments for the command.\n";
    echo "For help, use: php warvil help\n";
    exit(1);
}

// Add the arguments to a new array to be passed to the script
$scriptArgv = [$commandScript];
foreach ($commandArgs as $arg) {
    $scriptArgv[] = $arg;
}

// Include the script and pass the arguments
$argv = $scriptArgv;
require_once $commandScript;
