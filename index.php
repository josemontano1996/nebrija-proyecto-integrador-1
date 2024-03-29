<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/lib/authentication.php';

//I am using the dotenv package to load the environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

//I am autoloading the classes with the composer autoload, so my custom one 
//is not needed anymore
// require_once __DIR__ . '/src/autoload.php'; 

session_start();


use App\View;

define('ROOT_PATH', __DIR__);
define('VIEW_PATH', __DIR__ . '/public/views');
define('STORAGE_PATH', __DIR__ . '/public/assets/storage');

try {
    //Requiring the router file
    checkAuth();

    require_once __DIR__ . '/src/lib/routes.php';
} catch (App\Exceptions\RouteNotFoundException | App\Exceptions\ViewNotFoundException $e) {
    if ($e instanceof App\Exceptions\RouteNotFoundException) {
        $statusCode = 404;
        $viewPath = 'error/404';
    } elseif ($e instanceof App\Exceptions\ViewNotFoundException) {
        $statusCode = 404;
        $viewPath = 'error/404';
    }

    http_response_code($statusCode);
    echo (new View($viewPath))->render();
}
