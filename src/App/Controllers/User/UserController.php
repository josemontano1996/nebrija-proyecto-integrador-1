<?php

declare(strict_types=1);

namespace App\Controllers\User;

require_once __DIR__ .  '/../../../lib/validation.php';

use App\AuthSession;
use App\Models\UserModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;


class UserController
{
    /**
     * Retrieves the user account information and renders the account view.
     *
     * @return string|null The rendered account view or null if an error occurs.
     */
    public function getUserAccount(): ?string
    {
        try {
            // Get the user ID from the session
            $user_id = AuthSession::getUserId();

            // Get the user data from the database
            $user = UserModel::getUserById($user_id);

            if (!$user) {
                // If no user is found, return a 404 error
                ResponseStatus::sendResponseStatus(500, 'Error while fetching user data. Please try again later.', '/');
            }

            // Render the view with the user data
            return (new View('user/account', [$user]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while fetching user data. Please try again later.', '/');
        }
    }

    /**
     * Updates the user account information based on the submitted form data.
     *
     * @return void
     */
    public function updateUserAccount(): void
    {
        // Get the form data
        $user_name = $_POST['username'] ? trim($_POST['username']) : '';
        $email = $_POST['email'] ? trim($_POST['email']) : '';
        $password = $_POST['password'] ? trim($_POST['password']) : null;
        $confirm_password = $_POST['confirm_password'] ? trim($_POST['confirm_password']) : null;

        // Validate the form data
        if (!isValidString($user_name, 2)) {
            ResponseStatus::sendResponseStatus(400, 'Invalid username format', '/user/account');
        }
        if (!isValidEmail($email)) {
            ResponseStatus::sendResponseStatus(400, 'Invalid email format', '/user/account');
        }

        if (isset($password) && (!isValidString($password, 8) || !isValidString($confirm_password, 8))) {
            ResponseStatus::sendResponseStatus(400, 'Password must be at least 8 characters long', '/user/account');
        }

        if ($confirm_password !== $password) {
            ResponseStatus::sendResponseStatus(400, 'Passwords do not match', '/user/account');
        }

        try {
            // Get the user ID from the session
            $user_id = AuthSession::getUserId();

            // Update the user data in the database
            $result = UserModel::updateUser($user_id, $user_name, $email, $password);

            if (!$result) {
                // If the update was not successful, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Error while updating user data. Please try again later.', '/user/account');
            }

            // Send a success message
            ResponseStatus::sendResponseStatus(200, 'User data updated successfully', '/user/account');
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while updating user data. Please try again later.', '/user/account');
        }
    }
}
