<?php

namespace App\Controllers\Owner;

use App\Models\UserModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;

/**
 * Class OwnerUserController
 * 
 * This class handles the user-related actions for the owner role.
 */
class OwnerUserController
{
    /**
     * Get the users and render the view.
     * 
     * This method retrieves the users from the database, sorts them alphabetically by email,
     * and renders the view with the users.
     * 
     * @return string|null The rendered view with the users, or null if an error occurs.
     */
    public function getUsers(): ?string
    {
        // Get the page number from the GET request
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        try {

            // Get all users from the database
            $users = UserModel::getAllUsers($page, 20);

            if (!$users) {
                // If no users are found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'No users found', '/owner/users');
            }
            // Sort the users alphabetically by email
            $alphabeticalUsers = UserModel::sortUsersAlphabeticallyByEmail($users);

            // Render the view with the users
            return (new View('owner/users', [$alphabeticalUsers, $page]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/owner/users');
        }
    }

    /**
     * Search for a user by email and render the view.
     * 
     * This method searches for a user in the database based on the provided email,
     * and renders the view with the user's details.
     * 
     * @return string|null The rendered view with the user's details, or null if an error occurs.
     */
    public function searchUser(): ?string
    {
        // Get the email from the url
        $email = urldecode($_GET['email']) ?? '';

        try {
            // Get the user data from the database
            $user = UserModel::getUserByEmail($email);

            if (!$user) {
                // If no user is found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'User not found', '/owner/users');
            }
            // Render the view with the user data
            return (new View('owner/user', [$user]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/owner/users');
        }
    }
}
