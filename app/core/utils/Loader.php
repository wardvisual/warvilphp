<?php

namespace app\core\utils;

class Loader
{
    public static function load(string $folder, string $file, string $ext = 'php'): void
    {
        require_once $folder . '/' . $file . '.' . $ext;
    }

    public static function core(string $file): void
    {
        $path = 'app' . '/core';

        self::load($path, $file);
    }

    public static function config(string $file): void
    {
        $path = 'app' . '/config';

        self::load($path, $file);
    }
    public static function models(string $file): void
    {
        $path = 'app' . '/database/models';

        self::load($path, $file);
    }
}
