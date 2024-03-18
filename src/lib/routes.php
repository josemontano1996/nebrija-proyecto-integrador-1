
<?php

/**
 * This file contains the routes configuration for the application.
 * It defines the routes and their corresponding controller methods.
 */

$router = new \App\Router();

//Seed route
if ($_ENV['ENVIRONMENT'] === 'dev') {
    $router->get('/seed', [App\Seed\SeedController::class, 'seedDatabase']);
}

$router->get('/index.php', [App\Controllers\BaseController::class, 'getHomePage']);
$router->get('/', [App\Controllers\BaseController::class, 'getHomePage']);

$router->get('/menu', [App\Controllers\BaseController::class, 'getMenu']);
$router->get('/cart', [App\Controllers\CartController::class, 'getCart']);

$router->get('/login', [App\Controllers\AuthController::class, 'getLogIn']);
$router->post('/login', [App\Controllers\AuthController::class, 'postLogIn']);

$router->post('/register', [App\Controllers\AuthController::class, 'postRegister']);

$router->get('/logout', [App\Controllers\AuthController::class, 'getLogOut']);

//Protected routes


//Admin routes
$router->get('/admin/menu', [App\Controllers\Admin\AdminMenuController::class, 'getMenu']);

$router->get('/admin/product/new', [App\Controllers\Admin\AdminMenuController::class, 'getNewProduct']);
$router->post('/admin/product/new', [App\Controllers\Admin\AdminMenuController::class, 'postNewProduct']);

$router->get('/admin/product/update', [App\Controllers\Admin\AdminMenuController::class, 'getUpdateProduct']);
$router->post('/admin/product/update', [App\Controllers\Admin\AdminMenuController::class, 'postUpdateProduct']);
$router->delete('/admin/product/delete', [App\Controllers\Admin\AdminMenuController::class, 'deleteProduct']);


//This is the line that is going to resolve the route and send the result to the client
echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));