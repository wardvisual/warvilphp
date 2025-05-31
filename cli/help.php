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
    $purple = "\033[0;35m"; // Purple
    $green = "\033[0;32m";  // Green
    $yellow = "\033[1;33m"; // Yellow
    $cyan = "\033[1;36m";   // Cyan
    $white = "\033[1;37m";  // White
    $reset = "\033[0m";     // Reset

    echo "{$purple}
╦ ╦┌─┐┬─┐┬  ┬┬┬  ╔═╗╦ ╦╔═╗
║║║├─┤├┬┘└┐┌┘││  ╠═╝╠═╣╠═╝
╚╩╝┴ ┴┴└─ └┘ ┴┴─┘╩  ╩ ╩╩   
{$reset}

{$white}Command Line Interface for WarvilPHP Framework{$reset}

{$green}USAGE:{$reset}
  {$yellow}php warvil [command] [options]{$reset}

{$green}DATABASE COMMANDS:{$reset}
  {$cyan}warvil migration:run Class:up{$reset}     - Run a migration
  {$cyan}warvil migration:run Class:down{$reset}   - Reverse a migration
  {$cyan}warvil make:table TableName{$reset}       - Create a table schema

{$green}GENERATOR COMMANDS:{$reset}
  {$cyan}warvil make:model ModelName{$reset}       - Create a model
  {$cyan}warvil make:controller ControllerName{$reset} - Create a controller with views
  {$cyan}warvil make:view path/name{$reset}        - Create a view
  {$cyan}warvil make:middleware MiddlewareName{$reset} - Create a middleware
  {$cyan}warvil make:component path/ComponentName{$reset} - Create a component
  {$cyan}warvil make:service ServiceName{$reset}   - Create a service
  {$cyan}warvil make:api ControllerName{$reset}    - Create an API controller
  {$cyan}warvil make:layout LayoutName{$reset}     - Create a layout
  {$cyan}warvil make:resource ResourceName{$reset} - Create controller, API, model and views
  {$cyan}warvil make:test TestName{$reset}         - Create a test case

{$green}UTILITY COMMANDS:{$reset}
  {$cyan}warvil key:generate{$reset}               - Generate an application key
  {$cyan}warvil serve{$reset}                      - Start the development server
  {$cyan}warvil serve host port{$reset}            - Start server on specific host:port
  {$cyan}warvil help{$reset}                       - Show this help message
";
}

// Display help information
displayHelp();
