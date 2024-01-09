<?php
// RouterApi.php

namespace app\core;

class RouterApi
{
    protected static $routes = [];

    public static function get($url, $controller, $method)
    {
        $url = '/api' . $url;
        self::$routes['GET'][$url] = ['controller' => $controller, 'method' => $method];
    }

    public static function post($url, $controller, $method)
    {
        $url = '/api' . $url;
        self::$routes['POST'][$url] = ['controller' => $controller, 'method' => $method];
    }

    // Add other methods (put, delete) as needed
    public static function dispatch($url, $requestType)
    {
        try {
            $request = new Request();
            if (!isset(self::$routes[$requestType][$url])) {
                http_response_code(404);
                throw new \Exception('Route not found: ' . $url);
            }

            $controller = self::$routes[$requestType][$url]['controller'];
            $method = self::$routes[$requestType][$url]['method'];

            if ($method !== null && is_callable($method)) {
                call_user_func_array($method, [$request]);
            } else {
                $controllerFile = 'app/controllers/' . $controller . '.php';
                if (!file_exists($controllerFile)) {
                    http_response_code(500);
                    throw new \Exception('Controller file does not exist: ' . $controllerFile);
                }

                require_once $controllerFile;

                $controllerClass = 'app\\controllers\\' . $controller;
                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    throw new \Exception('Class does not exist: ' . $controllerClass);
                }

                $controllerObject = new $controllerClass;
                if (!method_exists($controllerObject, $method)) {
                    http_response_code(400);
                    throw new \Exception('Method not found: ' . $method);
                }

                call_user_func_array([$controllerObject, $method], [$request]);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $decodedMessage = json_decode($message);
            http_response_code($e->getCode());

            if (json_last_error() == JSON_ERROR_NONE) {
                $message = $decodedMessage;
            }

            Response::json(["success" => false, 'message' => $message]);
        }
    }
}
