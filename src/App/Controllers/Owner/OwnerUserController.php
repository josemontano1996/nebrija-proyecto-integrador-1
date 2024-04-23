<?php

namespace App\Controllers\Owner;

use App\Models\UserModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;

class OwnerUserController
{
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

    public function searchUser(): ?string
    {
        $email = urldecode($_GET['email']) ?? '';

        try {

            $user = UserModel::getUserByEmail($email);

            if (!$user) {
                ResponseStatus::sendResponseStatus(404, 'User not found', '/owner/users');
            }

            return (new View('owner/user', [$user]))->render();
        } catch (\Exception $e) {
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/owner/users');
        }
    }
}
