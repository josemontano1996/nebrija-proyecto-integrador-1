<?php

declare(strict_types=1);

namespace App;

use App\AuthSession;
use App\ResponseStatus;

/**
 * Class AuthMiddleware
 * 
 * This class provides middleware functionality for authentication.
 */
class AuthMiddleware
{
    /**
     * Checks if the user is authorized to access the requested route.
     * If not authorized, it sends a response with the appropriate status code and redirect URL.
     */
    static public function checkAuth(): void
    {
        // Get the requested route
        $route = explode('?', $_SERVER['REQUEST_URI'])[0];

        // Get the role from the route
        $route_role = explode('/', $route)[1] ?? null;


        // Check if the user is authorized based on the route role
        if ($route_role === 'user' && !AuthSession::isLoggedIn()) {
            ResponseStatus::sendResponseStatus(403, 'You are not authorized', '/login');
        }

        if ($route_role === 'admin') {
            $userRole = AuthSession::getUserRole();
            if (!in_array($userRole, ['admin', 'owner'])) {
                ResponseStatus::sendResponseStatus(403, 'You are not authorized', '/');
            }
        }

        if ($route_role === 'owner') {
            if (!AuthSession::isUserRole('owner')) {
                ResponseStatus::sendResponseStatus(403, 'You are not authorized', '/');
            }
        }
    }
}
