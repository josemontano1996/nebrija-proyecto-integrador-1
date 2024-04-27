<?php

namespace App\Models;

use App\DAO\UserManagementDAO;

/**
 * The UserManagementModel class represents the model for user management operations.
 */
class UserManagementModel
{
    /**
     * Retrieves the role of a user.
     *
     * @param string $user_id The ID of the user.
     * @return string|null The role of the user, or null if not found.
     */
    static public function getUserRole(string $user_id): ?string
    {
        $userManagementDAO = new UserManagementDAO();

        $user_role = $userManagementDAO->getUserRole($user_id);

        return $user_role;
    }

    /**
     * Updates the role of a user.
     *
     * @param string $owner_id The ID of the owner performing the update.
     * @param string $user_id The ID of the user to update.
     * @param string $role The new role for the user.
     * @return bool True if the update was successful, false otherwise.
     */
    static public function updateUserRole(string $owner_id, string $user_id, string $role): bool
    {
        $userManagementDAO = new UserManagementDAO();

        $previous_role = $userManagementDAO->getUserRole($user_id);

        $updateUserRole = $userManagementDAO->updateUserRole($owner_id, $user_id, $role);

        if (!$updateUserRole) {
            return false;
        }

        $updateSuccesfull = $userManagementDAO->saveUserManagementOperation($owner_id, $user_id, $role, $previous_role);

        return $updateSuccesfull;
    }

    /**
     * Retrieves the management logs.
     *
     * @param int|null $page The page number (optional).
     * @param int|null  $limit The maximum number of logs to retrieve (default: 5).
     * @return array|null An array of management logs, or null if not found.
     */
    static public function getManagementLogs(?int $page = null, ?int $limit = 5): ?array
    {
        $userManagementDAO = new UserManagementDAO();

        $user_management_logs = $userManagementDAO->getManagementLogs($page, $limit);

        return $user_management_logs;
    }

    /**
     * Retrieves the logs for a specific user email.
     *
     * @param string $email The email of the user.
     * @return array|null An array of logs for the user, or null if not found.
     */
    static public function getLogsByUserEmail(string $email): ?array
    {
        $userManagementDAO = new UserManagementDAO();

        $logs = $userManagementDAO->getLogsByUserEmail($email);

        return $logs;
    }
}
