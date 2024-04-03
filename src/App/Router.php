<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;

/**
 * Class Router
 * 
 * A class that handles routing in a web application.
 */
class Router
{
    private array $routes = [];

    /**
     * Register a route and its corresponding action.
     *
     * @param string $requestMethod The HTTP request method (e.g., GET, POST, PUT, DELETE).
     * @param string $route The route URL.
     * @param callable|array $action The action to be executed when the route is matched.
     * @return $this
     */
    public function register(string $requestMethod, string $route, callable|array $action)
    {
        // Store the route and action in the $routes array
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    /**
     * Register a GET route and its corresponding action.
     *
     * @param string $route The route URL.
     * @param callable|array $action The action to be executed when the route is matched.
     * @return $this
     */
    public function get(string $route, callable|array $action)
    {
        return $this->register('get', $route, $action);
    }

    /**
     * Register a POST route and its corresponding action.
     *
     * @param string $route The route URL.
     * @param callable|array $action The action to be executed when the route is matched.
     * @return $this
     */
    public function post(string $route, callable|array $action)
    {
        return $this->register('post', $route, $action);
    }

    /**
     * Register a PUT route and its corresponding action.
     *
     * @param string $route The route URL.
     * @param callable|array $action The action to be executed when the route is matched.
     * @return $this
     */
    public function put(string $route, callable|array $action)
    {
        return $this->register('put', $route, $action);
    }

    /**
     * Register a DELETE route and its corresponding action.
     *
     * @param string $route The route URL.
     * @param callable|array $action The action to be executed when the route is matched.
     * @return $this
     */
    public function delete(string $route, callable|array $action)
    {
        return $this->register('delete', $route, $action);
    }

    /**
     * Get all registered routes.
     *
     * @return array
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * Resolve the request URI and execute the corresponding action.
     *
     * @param string $requestUri The request URI.
     * @param string $requestMethod The HTTP request method.
     * @return mixed The result of the executed action.
     * @throws RouteNotFoundException If the route is not found.
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        // Remove query string from request URI
        $route = explode('?', $requestUri)[0];

        // Get the action for the route
        $action = $this->routes[$requestMethod][$route] ?? null;

        //If route is not found, throw an exception
        if (!$action) {
            throw new RouteNotFoundException();
        }

        //Calling the action from the route

        //If the action is a callable, call it
        if (is_callable($action)) {
            return call_user_func($action);
        }

        //If the action is an array, instantiate the class and call the method
        if (is_array($action)) {

            //Example: when registering the $router->register('/', [App\Controllers\HomeController::class, 'index']), the App\Controllers\HomeController::class would be the $class and 'index' would be the $method
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }

            //If for some reason the class or method does not exist, or types doesnt match  throw an exception 
            throw new RouteNotFoundException();
        }
    }
}
