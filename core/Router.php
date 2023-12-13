<?php

class Router
{
    public static function route($url)
    {
        // Load routes from the config file
        $routes = include(APP_PATH . 'config/routes.php');

        $urlParts = explode('/', $url);

        $controllerName = ucfirst($urlParts[0]) . 'Controller';
        $method = $urlParts[1] ?? 'index';
        $parameters = array_slice($urlParts, 2);

        // Check if the route is defined
        if (isset($routes[$url])) {
            list($controllerName, $method) = explode('@', $routes[$url]);
        }

        $controllerPath = APP_PATH . 'controllers/' . $controllerName . '.php';

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerName;

            if (method_exists($controller, $method)) {
                $controller->$method(...$parameters);
            } else {
                // Handle method not found
                die('Method not found');
            }
        } else {
            // Handle controller not found
            die('Controller not found');
        }
    }
}
