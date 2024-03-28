<?php

namespace App\Models;

use App\DAO\UserManagementDAO;

class UserManagementModel
{

    static public function updateUserRole(string $owner_id, string $user_id, string $role): bool
    {
        $userDAO = new UserManagementDAO();

        $previous_role = $userDAO->getUserRole($user_id);

        $updateUserRole = $userDAO->updateUserRole($owner_id, $user_id, $role);

        if (!$updateUserRole) {
            return false;
        }

        $updateSuccesfull = $userDAO->saveUserManagementOperation($owner_id, $user_id, $role, $previous_role);

        return $updateSuccesfull;
    }
}
