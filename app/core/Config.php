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
        } else {
            // Handle the case when the config file is not found
            echo 'Error: Configuration file not found';
            self::$config = [];
        }
    }
}
