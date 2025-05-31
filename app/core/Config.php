<?php

namespace app\core;

class Config
{
    protected static $config;

    public static function get($key, $default = null)
    {
        if (!self::$config) {
            self::loadConfig();
        }

        $keys = explode('/', $key);
        
        // First check if it's an environment variable
        if ($keys[0] === 'env') {
            return Env::get($keys[1], $default);
        }
        
        // Special handling for layout paths
        if ($keys[0] === 'paths' && $keys[1] === 'layouts') {
            // Handle layout paths specially
            if ($keys[2] === 'welcome') {
                return 'app/shared/layouts/welcome.php';
            }
            if ($keys[2] === 'default') {
                return 'app/shared/layouts/main.php';
            }
            
            // Try to construct a path for other layouts
            return 'app/shared/layouts/' . $keys[2] . '.php';
        }
        
        $current = self::$config;

        foreach ($keys as $nestedKey) {
            if (isset($current[$nestedKey])) {
                $current = $current[$nestedKey];
            } else {
                return $default;
            }
        }

        return $current;
    }

    protected static function loadConfig()
    {
        $configFile = 'warvil.json';

        if (file_exists($configFile)) {
            $configContent = file_get_contents($configFile);
            self::$config = json_decode($configContent, true) ?: [];

                        
            // Override database config with environment variables
            if (isset(self::$config['database'])) {
                self::$config['database']['driver'] = Env::get('DB_DRIVER', self::$config['database']['driver']);
                self::$config['database']['host'] = Env::get('DB_HOST', self::$config['database']['host']);
                self::$config['database']['dbname'] = Env::get('DB_DATABASE', self::$config['database']['dbname']);
                self::$config['database']['username'] = Env::get('DB_USERNAME', self::$config['database']['username']);
                self::$config['database']['password'] = Env::get('DB_PASSWORD', self::$config['database']['password']);
            }
            
            // Override storage config
            if (isset(self::$config['config']['storage'])) {
                self::$config['config']['storage']['directory'] = Env::get('STORAGE_DIRECTORY', self::$config['config']['storage']['directory']);
                self::$config['config']['storage']['max_size'] = Env::get('STORAGE_MAX_SIZE', self::$config['config']['storage']['max_size']);
            }
        } else {
            // Create a default config
            self::$config = [
                'name' => 'WarvilPHP',
                'description' => 'A lightweight PHP framework',
                'author' => 'WardVisual',
                'paths' => [
                    'layouts' => [
                        'default' => 'app/shared/layouts/main.php',
                        'welcome' => 'app/shared/layouts/welcome.php'
                    ]
                ]
            ];
        }
    }
}