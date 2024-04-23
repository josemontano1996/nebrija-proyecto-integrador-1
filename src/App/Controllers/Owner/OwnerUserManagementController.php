<?php

namespace App\Controllers\Owner;

use App\AuthSession;
use App\Models\UserManagementModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;

/**
 * Class OwnerUserManagementController
 * 
 * This class handles the user management functionality for the owner role.
 */
class OwnerUserManagementController
{
    /**
     * Update the role of a user.
     * 
     * This method updates the role of a user based on the provided user ID, email, and role.
     * It performs various checks and validations before updating the role.
     * 
     * @return void
     */
    public function updateUserRole(): void
    {
        // Get the user ID, email and role from the POST request
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $role = isset($_POST['role']) ? $_POST['role'] : null;

        // Encoding the redirect URL pointing at the email search page
        $url_enconded_redirect = '/owner/user/search?email=' . urlencode($email);

        // Check if the email is set
        if (!isset($email)) {
            ResponseStatus::sendResponseStatus(400, 'User email required', '/owner/users');
        }

        // Check if the user ID is set
        if (!$user_id) {
            ResponseStatus::sendResponseStatus(400, 'User ID required', $url_enconded_redirect);
        }

        // Check if the role set is valid (owner or admin), if not set they are taking 
        //out the priviledgeds from the user and making it a normal User without role
        if ($role && ($role !== 'owner' && $role !== 'admin')) {
            ResponseStatus::sendResponseStatus(400, 'Invalid role', $url_enconded_redirect);
        }
        
        // Get the current role of the user
        $currentUserRole = UserManagementModel::getUserRole($user_id);

        // Check if the user has the role already
        if ($currentUserRole === $role) {
            ResponseStatus::sendResponseStatus(400, 'User already has this role', $url_enconded_redirect);
        }

        // Check if the user is trying to downgrade another owner, owners can't downgrade other owners
        if ($role !== 'owner' && $user_id !== AuthSession::getUserId()) {
            if ($currentUserRole === 'owner') {
                ResponseStatus::sendResponseStatus(400, 'You cannot downgrade another owner', $url_enconded_redirect);
            }
        }

        // Get the owner ID that is making the change
        $owner_id = AuthSession::getUserId();

        try {
            // Update the user role
            $updateSuccessful = UserManagementModel::updateUserRole($owner_id, $user_id, $role);

            if (!$updateSuccessful) {
                // If the update was not successful, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Failed to update user role', $url_enconded_redirect);
            }
            // Send a success message
            ResponseStatus::sendResponseStatus(200, 'User role updated successfully', $url_enconded_redirect);
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred', $url_enconded_redirect);
        }
    }

    /**
     * Get the management logs.
     * 
     * This method retrieves the management logs for user management operations.
     * It takes the page number as a parameter and returns the logs in a formatted view.
     * 
     * @return string|null The rendered view with the logs, or null if an error occurs.
     */
    public function getManagementLogs(): ?string
    {
        // Get the page number from the GET request
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        try {

            // Get the logs from the UserManagementModel
            $logs = UserManagementModel::getManagementLogs($page, 20);

            if (!$logs) {
                // If no logs are found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'No logs found', '/owner/users');
            }

            // Render the view with the logs
            return (new View('owner/user-management-logs', [$logs, $page]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/owner/users');
        }
    }

    /**
     * Get the logs by user email.
     * 
     * This method retrieves the logs for a specific user based on their email.
     * It takes the email as a parameter and returns the logs in a formatted view.
     * 
     * @return string|null The rendered view with the logs, or null if an error occurs.
     */
    public function getLogsByUserEmail(): ?string
    {
        // Get the email from the url 
        $email = urldecode($_GET['email']) ?? '';

        try {
            // Get the logs from the UserManagementModel
            $logs = UserManagementModel::getLogsByUserEmail($email);
            if (!$logs) {
                // If no logs are found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'No logs found', '/owner/users');
            }
            return (new View('owner/logs-user', [$logs, $email]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/owner/users');
        }
    }
}
