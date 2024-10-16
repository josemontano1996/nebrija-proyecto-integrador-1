<?php

require_once __DIR__ . '/vendor/autoload.php';

//I am using the dotenv package to load the environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

//I am autoloading the classes with the composer autoload, so my custom one 
//is not needed anymore
// require_once __DIR__ . '/src/autoload.php'; 

//Starting the session, this will make the $_SESSION variable available in the rest of the application
session_start();

use App\View;
use App\AuthMiddleware;

define('ROOT_PATH', __DIR__);
define('VIEW_PATH', __DIR__ . '/src/front/views');
define('STORAGE_PATH', __DIR__ . '/src/front/assets/storage');

try {
    //Using AuthMiddleware class to check if the user is authenticated
    AuthMiddleware::checkAuth();

    require_once __DIR__ . '/src/lib/routes.php';
} catch (App\Exceptions\RouteNotFoundException | App\Exceptions\ViewNotFoundException $e) {
    //Handling the exceptions
    if ($e instanceof App\Exceptions\RouteNotFoundException) {
        $statusCode = 404;
        $viewPath = 'error/404';
    } elseif ($e instanceof App\Exceptions\ViewNotFoundException) {
        $statusCode = 404;
        $viewPath = 'error/404';
    }

    //Setting the status code and rendering the view
    http_response_code($statusCode);
    echo (new View($viewPath))->render();
}
