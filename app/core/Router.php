<?php

namespace app\core;

use app\core\utils\UrlHelper;

//! note this is the same with RouterAPI, you just need to add status code, and namespace if possible
class Router
{

    protected static $routes = [];
    private static $middlewares = [];
    private static $isRouteTriggered = false;

    private static function formatUrl($url)
    {
        self::$isRouteTriggered = true;
        // Ensure consistent URL formatting
        $url = '/' . trim($url, '/');
        if ($url !== '/') {
            $url .= '/';
        }

        return $url;
    }

    public static function get($url, $controller, $method)
    {
        $url = self::formatUrl($url);
        self::$routes['GET'][$url] = ['controller' => $controller, 'method' => $method];
        return new static;
    }

    public static function post($url, $controller, $method)
    {
        $url = self::formatUrl($url);
        self::$routes['POST'][$url] = ['controller' => $controller, 'method' => $method];
        return new static;
    }

    public static function delete($url, $controller, $method)
    {
        $url = self::formatUrl($url);
        self::$routes['DELETE'][$url] = ['controller' => $controller, 'method' => $method];

        return new static;
    }

    public static function put($url, $controller, $method)
    {
        $url = self::formatUrl($url);
        // self::$routes['PUT'][$url] = ['controller' => $controller, 'method' => $method];
        self::$routes['POST'][$url] = ['controller' => $controller, 'method' => $method];

        return new static;
    }

    public static function middleware($middleware)
    {
        if (self::$isRouteTriggered) {
            if (is_string($middleware)) {
                self::$middlewares[] = $middleware;
            } elseif (is_array($middleware)) {
                self::$middlewares = array_merge(self::$middlewares, $middleware);
            }
        }
    }

    public static function group($prefix, $callback)
    {
        $uri = '/' . UrlHelper::currentUri();
        Session::flash('route/prefix', $prefix);

        // Only run the callback and modify the routes if the URI starts with the prefix
        if ($uri === $prefix || strpos($uri, $prefix . '/') === 0) {
            self::$isRouteTriggered = true;
            // Store the current routes
            $currentRoutes = self::$routes;

            // Clear the routes
            self::$routes = [];

            // Run the callback to define the routes
            call_user_func($callback);

            // Get the routes defined in the callback
            $newRoutes = self::$routes;

            // Restore the original routes
            self::$routes = $currentRoutes;

            // Add the new routes with the prefix
            foreach ($newRoutes as $requestType => $routes) {
                foreach ($routes as $route => $action) {
                    self::$routes[$requestType][$prefix . $route] = $action;
                }
            }

            return new static;
        }

        self::$isRouteTriggered = false;
        return new static;
    }

    public static function dispatch($url, $requestType)
    {
        try {
            $request = new Request();
            $request->capture();

            // Normalize URL format for matching with routes
            $url = '/' . trim($url, '/');
            if ($url !== '/') {
                $url .= '/';
            }

            $url = self::matchRoute($url, $requestType);

            if (!isset(self::$routes[$requestType][$url])) {
                throw new \Exception('Route not found: ' . $url);
            }

            $controller = self::$routes[$requestType][$url]['controller'];
            $method = self::$routes[$requestType][$url]['method'];

            foreach (self::$middlewares as $middleware) {
                // If middleware is not empty
                if (!empty($middleware)) {
                    // If middleware is a string, assume it's a class name
                    if (is_string($middleware)) {
                        $middleware = ucfirst($middleware) . 'Middleware';
                        $middlewareFile = 'app/middlewares/' . $middleware . '.php';

                        if (!file_exists($middlewareFile)) {
                            throw new \Exception('Middleware file does not exist: ' . $middlewareFile);
                        }

                        require_once $middlewareFile;

                        $middlewareClass = 'app\\middlewares\\' . $middleware;
                        if (!class_exists($middlewareClass)) {
                            throw new \Exception('Class does not exist: ' . $middlewareClass);
                        }

                        $middlewareInstance = new $middlewareClass();
                        // dd($middlewareInstance);
                        if (method_exists($middlewareInstance, 'handle')) {
                            $middlewareInstance->handle($request);
                        }
                    }
                    // If middleware is a callable, call it directly
                    elseif (is_callable($middleware)) {
                        call_user_func($middleware, $request);
                    }
                }
            }
            if ($method !== null && is_callable($method)) {
                call_user_func_array($method, [$request]);
            } else {
                self::callControllerMethod($controller, $method, $request);
            }
        } catch (\Exception $e) {
            self::handleException($e);
        }
    }

    private static function matchRoute($url, $requestType)
    {
        $url = rtrim($url, '/');  // Remove trailing slash if present

        foreach (self::$routes[$requestType] as $route => $action) {
            // Remove initial forward slash from the route
            $route = ltrim($route, '/');
            $pattern = preg_replace('/\/{([^\/]+)}/', '/([^/]+)', $route);
            $pattern = '@^' . str_replace('/', '\/', $pattern) . '$@';

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches); // Remove the full match

                preg_match_all('/{([^}]+)}/', $route, $paramNames);
                $paramNames = $paramNames[1];

                if (!empty($paramNames)) {
                    $params = array_combine($paramNames, $matches);
                    Request::setParams($params);
                }

                return $route;
            }
        }

        return $url . '/';
    }

    private static function callControllerMethod($controller, $method, $request)
    {
        $controllerFile = 'app/controllers/' . $controller . '.php';
        if (!file_exists($controllerFile)) {
            throw new \Exception('Controller file does not exist: ' . $controllerFile);
        }

        require_once $controllerFile;

        $controllerClass = 'app\\controllers\\' . $controller;
        if (!class_exists($controllerClass)) {
            throw new \Exception('Class does not exist: ' . $controllerClass);
        }

        $controllerObject = new $controllerClass;
        if (!method_exists($controllerObject, $method)) {
            throw new \Exception('Method not found: ' . $method);
        }

        call_user_func_array([$controllerObject, $method], [$request]);
    }

    private static function handleException($e)
    {
        $message = $e->getMessage();
        $decodedMessage = json_decode($message);
        http_response_code((int)$e->getCode());

        if (json_last_error() == JSON_ERROR_NONE) {
            $message = $decodedMessage;
        }

        Response::json(["success" => false, 'message' => $message]);
    }
}
