<?php

namespace App\Models;

use App\DAO\UserManagementDAO;

class UserManagementModel
{

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

    static public function getManagementLogs(int $page = null, int $limit = 5): ?array
    {
        $userManagementDAO = new UserManagementDAO();

        $user_management_logs = $userManagementDAO->getManagementLogs($page, $limit);

        return $user_management_logs;
    }

    static public function getLogsByUserEmail(string $email): ?array
    {
        $userManagementDAO = new UserManagementDAO();

        $logs = $userManagementDAO->getLogsByUserEmail($email);

        return $logs;
    }
}
