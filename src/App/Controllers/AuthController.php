<?php

declare(strict_types=1);

namespace App\Controllers;

require_once ROOT_PATH . '/src/lib/validation.php';

use App\AuthSession;
use App\Models\Cart\CartCookie;
use App\Models\Cart\CartDb;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;
use App\Models\UserModel;

/**
 * The AuthController class handles user authentication and registration.
 */
class AuthController
{
    /**
     * Retrieves the login view if the user is not already logged in.
     * If the user is already logged in, redirects to the menu page.
     *
     * @return string The rendered login view.
     */
    public function getLogIn(): ?string
    {
        if (AuthSession::isLoggedIn()) {
            // Redirect to the menu page if the user is already logged in
            ResponseStatus::sendResponseStatus(302, 'You are already logged in', '/menu');
        } else {
            return (new View('login'))->render();
        }
    }

    /**
     * Handles the login form submission.
     * Validates the email and password, and logs in the user if valid.
     * Redirects to the appropriate page based on the user's role and load the cart from the database into the cookie.
     */
    public function postLogIn(): void
    {
        // Checking if user is already logged in
        if (AuthSession::isLoggedIn()) {
            // Redirect to the menu page if the user is already logged in
            ResponseStatus::sendResponseStatus(302, 'You are already logged in', '/menu');
        }

        // Input validation
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!isValidEmail($email)) {
            ResponseStatus::sendResponseStatus(401, 'Insert a valid email', '/login');
        }

        if (empty($password) || !strlen($password) >= 8) {
            ResponseStatus::sendResponseStatus(401, 'Insert a valid password', '/login');
        }

        try {
            // Process login
            $userInstance = new UserModel($email, $password);
            $user = $userInstance->login();

            if ($user) {
                // Load the cart from the database into the cookie
                $cartDb = new CartDb($user->getId(), new CartCookie());
                $dbCartData = $cartDb->loadCart();

                if ($dbCartData) {
                    // Create a new cart cookie with the data from the database
                    CartCookie::createCartCookie($dbCartData);
                }

                // Save the user in the session
                $authSession = new AuthSession($user);
                $authSession->save();

                if ($user->getRole() === 'admin' || $user->getRole() === 'owner') {
                    // Redirect to the admin menu if the user is an admin or owner
                    ResponseStatus::sendResponseStatus(200, null, '/admin/menu');
                } else {
                    // Redirect to the menu page if the user is a regular user
                    ResponseStatus::sendResponseStatus(200, null, '/menu');
                }
            } else {
                // Redirect to the login page with an error message if the login failed
                ResponseStatus::sendResponseStatus(401, 'Invalid email or password', '/login');
            }
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error occurred, try again later', '/login');
        }
    }

    /**
     * Handles the registration form submission.
     * Validates the username, email, and password, and registers the user if valid.
     * Redirects to the login page with success or error messages.
     */
    public function postRegister(): void
    {
        // Checking if user is already logged in
        if (isset($_SESSION['user'])) {
            ResponseStatus::sendResponseStatus(403, 'You are already logged in', '/login');
        }

        // Input validation
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        if (!isValidString($username, 3)) {
            ResponseStatus::sendResponseStatus(401, 'Insert a valid name', '/login');
        }

        if (!isValidEmail($email)) {
            ResponseStatus::sendResponseStatus(401, 'Insert a valid email', '/login');
        }

        if (empty($password) || !strlen($password) >= 8 || $password !== $confirm_password) {
            ResponseStatus::sendResponseStatus(401, 'Insert a valid password, or validate your passwords', '/login');
        }

        // Process registration
        try {
            // Register the user
            $userInstance = new UserModel($email, $password, $username);
            $result = $userInstance->register();

            if (!$result) {
                // Redirect to the login page with an error message if the registration failed
                ResponseStatus::sendResponseStatus(500, 'An error occurred', '/login');
            }

            // Redirect to the login page with a success message if the registration was successful
            ResponseStatus::sendResponseStatus(200, 'User registered successfully', '/login');
        } catch (\Exception $e) {
            // Log the error and return the error message
            ServerErrorLog::logError($e);

            if ($e->getCode() === 1062) {
                ResponseStatus::sendResponseStatus(403, 'User already exists', '/login');
            } else {
                ResponseStatus::sendResponseStatus(500, 'An error occurred', '/login');
            }
        }
    }

    /**
     * Logs out the user by destroying the session, saving the cart cookie in the database and redirecting to the login page.
     */
    public function getLogOut(): void
    {
        // Checking if user is not logged in
        $userId = AuthSession::getUserId();

        try {
            // Save the cart cookie in the database
            $cartDb = new CartDb($userId, new CartCookie());
            $cartDb->saveCart();

            // Destroy the the cart cookie
            CartCookie::destroyCartCookie();

            // Destroy the authentication session
            AuthSession::destroy();

            // Redirect to the login page with a success message
            ResponseStatus::sendResponseStatus(200, 'You have been logged out', '/login');
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error occurred', '/login');
        }
    }
}
