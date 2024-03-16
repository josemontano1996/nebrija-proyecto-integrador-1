<?php

namespace App\Controllers;

require_once ROOT_PATH . '/src/lib/validation.php';

use App\View;
use App\DB;
use App\Models\UserModel;
use App\Models\ProductModel as Product;
use App\Models\CartModel;
use App\Classes\Cart\Cart;
use App\Classes\Cart\CartCookie;


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
    public function getLogIn(): string
    {
        if (isset($_SESSION['user'])) {
            http_response_code(302);
            header('Location: /menu');
            exit();
        } else {
            return (new View('login'))->render();
        }
    }

    /**
     * Handles the login form submission.
     * Validates the email and password, and logs in the user if valid.
     * Redirects to the appropriate page based on the user's role.
     */
    public function postLogIn(): void
    {
        // Checking if user is already logged in
        if (isset($_SESSION['user'])) {
            $_SESSION['error'] = 'You are already logged in';
            http_response_code(403);
            header('Location: /login');
            exit();
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!isValidEmail($email)) {
            $_SESSION['error'] = 'Insert a valid email';
            http_response_code(401);
            header('Location: /login');
            exit();
        }

        if (empty($password) || !strlen($password) >= 8) {
            $_SESSION['error'] = 'Insert a valid password';
            http_response_code(401);
            header('Location: /login');
            exit();
        }

        try {

            $dbInstance = DB::getInstance();
            $db = $dbInstance->getDb();

            $userInstance = new UserModel($email, $password);
            $user = $userInstance->login($db);

            $db->close();

            if ($user) {
                $_SESSION['user']['id'] = $user['id'];
                if (!empty($user['role'])) {
                    $_SESSION['user']['role'] = $user['role'];
                }
                if ($user['role'] === 'admin' || $user['role'] === 'owner') {
                    header('Location: /admin/menu');
                } else {
                    header('Location: /menu');
                }
            } else {
                $_SESSION['error'] = 'Invalid email or password';
                http_response_code(401);
                header('Location: /login');
                exit();
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error occurred, try again later';
            http_response_code(500);
            header('Location: /login');
            exit();
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
            $_SESSION['error'] = 'You are already logged in';
            http_response_code(403);
            header('Location: /login');
            exit();
        }

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Input validation
        if (!isValidString($username, 3)) {
            $_SESSION['error'] = 'Insert a valid name';
            http_response_code(401);
            header('Location: /login');
            exit();
        }

        if (!isValidEmail($email)) {
            $_SESSION['error'] = 'Insert a valid email';
            http_response_code(401);
            header('Location: /login?error=Invalid email');
            exit();
        }

        if (empty($password) || !strlen($password) >= 8 || $password !== $confirm_password) {
            $_SESSION['error'] = 'Insert a valid password, or validate your passwords';
            http_response_code(401);
            header('Location: /login');
            exit();
        }

        // Process registration
        try {

          
            $user = new UserModel($email, $password, $username);
            $result = $user->register();

            if (!$result) {
                $_SESSION['error'] = 'An error occurred';
                http_response_code(500);
                header('Location: /login');
                exit();
            }

            header('Location: /login?success=User registered successfully');
        } catch (\Exception $e) {
            if ($e->getCode() === 1062) {
                $_SESSION['error'] = 'User already exists';
                http_response_code(403);
                header('Location: /login');
                exit();
            } else {
                $_SESSION['error'] = 'An error occurred';
                http_response_code(500);
                header('Location: /login');
                exit();
            }
        }
    }

    /**
     * Logs out the user by destroying the session and redirecting to the login page.
     */
    public function getLogOut(): void
    {
        /*      $cookieCart = new CartCookie();

        if ($cookieCart) {
            $ids = $cookieCart->fetchIds();

            [$products, $notFoundProduct] = Product::getProductsByIds($ids);

            $cleanedUpCart = new Cart($products, $cookieCart);

            $cart = new CartCookie($cleanedUpCart);

            $dbCart = new CartModel($_SESSION['user']['id'], $cart);

            $result = $dbCart->saveCart();
        }

        exit(); */

        session_destroy();
        header('Location: /login?success=Logged out successfully');
    }
}
