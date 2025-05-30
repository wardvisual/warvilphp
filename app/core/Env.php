<?php

namespace app\core;

class Env
{
    /**
     * The path to the .env file
     */
    protected static $path = null;

    /**
     * Load .env file
     */
    public static function load($path = null)
    {
        self::$path = $path ?: WARVIL_ROOT . '/.env';

        if (!file_exists(self::$path)) {
            return false;
        }

        $lines = file(self::$path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Split by the first = character
            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value);

            // Remove quotes from value
            if (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) {
                $value = substr($value, 1, -1);
            } elseif (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1) {
                $value = substr($value, 1, -1);
            }

            // Set environment variable
            putenv("{$key}={$value}");

            // Also set as $_ENV and $_SERVER
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        return true;
    }

    /**
     * Get an environment variable
     */
    public static function get($key, $default = null)
    {
        $value = getenv($key);
        return $value !== false ? $value : $default;
    }
}