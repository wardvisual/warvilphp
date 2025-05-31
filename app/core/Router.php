<?php

namespace app\core;

class Router
{
    protected static $routes = [];

    public static function add($url, $controller, $method)
    {
        self::$routes[$url] = ['controller' => $controller, 'method' => $method];
    }

    public static function get($url, $controller, $method)
    {
        self::$routes['GET'][$url] = ['controller' => $controller, 'method' => $method];
    }

    public static function post($url, $controller, $method)
    {
        self::$routes['POST'][$url] = ['controller' => $controller, 'method' => $method];
    }

    public static function dispatch($url, $requestType)
    {
        try {
            $request = new Request();

            if (!isset(self::$routes[$requestType][$url])) {
                throw new \Exception('Route not found: ' . $url, 404);
            }

            $controller = self::$routes[$requestType][$url]['controller'];
            $method = self::$routes[$requestType][$url]['method'];

            if ($method !== null && is_callable($method)) {
                call_user_func_array($method, [$request]);
            } else {
                // Check if controller is a namespaced class name or a file name
                if (strpos($controller, '\\') !== false) {
                    // It's a fully qualified class name
                    $controllerClass = $controller;
                    
                    // Create controller instance
                    if (!class_exists($controllerClass)) {
                        throw new \Exception('Class does not exist: ' . $controllerClass, 500);
                    }
                    $controllerObject = new $controllerClass();
                } else {
                    // It's a controller file name without namespace
                    $controllerFile = 'app/controllers/' . $controller . '.php';
                    if (!file_exists($controllerFile)) {
                        throw new \Exception('Controller file does not exist: ' . $controllerFile, 500);
                    }

                    require_once $controllerFile;
                    
                    // Try both namespace conventions (with and without namespace)
                    if (class_exists('app\\controllers\\' . $controller)) {
                        $controllerClass = 'app\\controllers\\' . $controller;
                        $controllerObject = new $controllerClass();
                    } else if (class_exists($controller)) {
                        $controllerObject = new $controller();
                    } else {
                        throw new \Exception('Controller class not found: ' . $controller, 500);
                    }
                }

                if (!method_exists($controllerObject, $method)) {
                    throw new \Exception('Method not found: ' . $method, 404);
                }

                call_user_func_array([$controllerObject, $method], [$request]);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $decodedMessage = json_decode($message);
            $code = $e->getCode() ?: 500;
            http_response_code($code);

            if (json_last_error() == JSON_ERROR_NONE) {
                $message = $decodedMessage;
            }

            Response::json(["success" => false, 'message' => $message]);
        }
    }

    /**
     * Register resource routes for a controller
     *
     * @param string $name
     * @param string $controller
     * @return void
     */
    public static function resource($name, $controller)
    {
        self::get('/' . $name, $controller, 'index');
        self::get('/' . $name . '/create', $controller, 'create');
        self::post('/' . $name . '/store', $controller, 'store');
        self::get('/' . $name . '/show', $controller, 'show');
        self::get('/' . $name . '/edit', $controller, 'edit');
        self::post('/' . $name . '/update', $controller, 'update');
        self::post('/' . $name . '/destroy', $controller, 'destroy');
    }
}