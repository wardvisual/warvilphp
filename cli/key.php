#!/usr/bin/env php
<?php
// filepath: c:\xampp\htdocs\warvilphp\cli\key.php

/**
 * Generate application key for encryption and security
 */
function generateAppKey()
{
    // Generate a secure random key
    $randomKey = base64_encode(random_bytes(32));
    $envFile = '.env';
    
    if (!file_exists($envFile)) {
        echo "\033[1;31mError: .env file does not exist.\033[0m\n";
        echo "Creating .env file from .env.example...\n";
        
        if (file_exists('.env.example')) {
            copy('.env.example', '.env');
            echo "\033[0;32m✓ \033[0m.env file created successfully.\n";
        } else {
            echo "\033[1;31mError: .env.example file not found.\033[0m\n";
            echo "Creating a basic .env file...\n";
            
            $basicEnv = "APP_NAME=WarvilPHP\n";
            $basicEnv .= "APP_ENV=local\n";
            $basicEnv .= "APP_DEBUG=true\n";
            $basicEnv .= "APP_URL=http://localhost\n\n";
            
            $basicEnv .= "DB_DRIVER=mysql\n";
            $basicEnv .= "DB_HOST=localhost\n";
            $basicEnv .= "DB_PORT=3306\n";
            $basicEnv .= "DB_DATABASE=warvilphp\n";
            $basicEnv .= "DB_USERNAME=root\n";
            $basicEnv .= "DB_PASSWORD=\n\n";
            
            $basicEnv .= "STORAGE_DIRECTORY=/public/uploads\n";
            $basicEnv .= "STORAGE_MAX_SIZE=1000000\n";
            
            file_put_contents('.env', $basicEnv);
            echo "\033[0;32m✓ \033[0mBasic .env file created.\n";
        }
    }
    
    $envContent = file_get_contents($envFile);
    
    // Check if APP_KEY exists in the file
    if (strpos($envContent, 'APP_KEY=') !== false) {
        // Replace existing APP_KEY
        $envContent = preg_replace('/APP_KEY=.*/', "APP_KEY=base64:{$randomKey}", $envContent);
    } else {
        // Add APP_KEY to the file
        $envContent .= "\nAPP_KEY=base64:{$randomKey}\n";
    }
    
    file_put_contents($envFile, $envContent);
    
    echo "\033[0;32m✓ \033[0mApplication key set successfully: \033[1;33mbase64:{$randomKey}\033[0m\n";
}

// No arguments needed for this command
generateAppKey();