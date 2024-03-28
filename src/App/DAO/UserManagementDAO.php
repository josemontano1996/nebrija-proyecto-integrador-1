<?php

namespace App\DAO;

use App\DB;
use mysqli;

class UserManagementDAO
{
    private mysqli $db;

    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    public function updateUserRole(string $owner_id, string $user_id, string $role): bool
    {
        $db = $this->db;

        $owner_id = $db->real_escape_string($owner_id);
        $user_id = $db->real_escape_string($user_id);
        $role = $db->real_escape_string($role);

        if (!$role) {
            $role = null;
        }
     
        $sql = "UPDATE users SET role = ? WHERE id = ? ";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('ss', $role, $user_id);

        $result = $stmt->execute();

        if (!$result) {
            return false;
        }
       
        $stmt->close();

        return $result;
    }

    public function getUserRole(string $user_id): ?string
    {
        $db = $this->db;

        $user_id = $db->real_escape_string($user_id);

        $sql = "SELECT role FROM users WHERE id = ?";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('s', $user_id);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $role = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $role['role'];
    }

    public function saveUserManagementOperation(string $owner_id, string $user_id, string $new_role, ?string $previous_role): bool
    {
        $db = $this->db;

        $owner_id = $db->real_escape_string($owner_id);
        $user_id = $db->real_escape_string($user_id);
        $new_role = $db->real_escape_string($new_role);
        $previous_role = $db->real_escape_string($previous_role);

        $sql = "INSERT INTO user_management (owner_id, user_id, new_role, previous_role) VALUES (?, ?, ?, ?)";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('ssss', $owner_id, $user_id, $new_role, $previous_role);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
}
