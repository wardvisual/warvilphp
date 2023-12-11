<?php

namespace app\core\utils;

use app\core\App;

class UrlHelper
{

    /**
     * Get the current URL.
     *
     * @return string
     */
    public static function currentUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function currentPath()
    {
        // Get the path from the URL
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove leading and trailing slashes and return the path
        return trim($path, '/');
    }

    /**
     * Get the base URL (domain and protocol).
     *
     * @return string
     */
    public static function baseUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'];
    }

    /**
     * Get the query string as an array.
     *
     * @return array
     */
    public static function getQueryParameters()
    {
        parse_str($_SERVER['QUERY_STRING'], $queryParameters);
        return $queryParameters;
    }

    /**
     * Get a specific query parameter by name.
     *
     * @param string $name
     * @return string|null
     */
    public static function getQueryParameter($name)
    {
        $queryParameters = self::getQueryParameters();
        return $queryParameters[$name] ?? null;
    }

    /**
     * Get the URL path components as an array.
     *
     * @return array
     */
    public static function getPathSegments()
    {
        return explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    }

    public static function newUrl($path)
    {
        $newPath = '';

        if (App::isProduction()) {
            $newPath = UrlHelper::baseUrl() . '/' . $path;
        } else {
            $newPath = UrlHelper::baseUrl() . '/mvc' . '/' . $path;
        }

        return $newPath;
    }
}
