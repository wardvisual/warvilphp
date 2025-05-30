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
            // Handle the case when the config file is not found
            echo 'Error: Configuration file not found';
            self::$config = [];
        }
    }
}