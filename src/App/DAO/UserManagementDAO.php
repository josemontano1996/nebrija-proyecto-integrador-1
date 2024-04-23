<?php

namespace App\DAO;

use App\DB;
use App\Models\Classes\UserManagementLog;
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

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $result['role'];
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

    public function getManagementLogs(int $page = null, int $limit = 5): ?array
    {
        $db = $this->db;

        $sql = "SELECT user_management.*, owner.email as owner_email, owner.name as owner_name, user.email as user_email, user.name as user_name FROM user_management
        INNER JOIN users as owner ON user_management.owner_id = owner.id 
        INNER JOIN users as user ON user_management.user_id = user.id  
        ORDER BY date DESC";

        if (isset($page)) {
            $start = 0;
            if ($page > 0) {
                $start = ($page - 1) * $limit;
            }
            $sql = $sql . " LIMIT $start, $limit";
        }

        $stmt = $db->prepare($sql);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $raw_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $logs = [];
        foreach ($raw_data as $data) {
            $logs[] = new UserManagementLog($data['owner_id'], $data['user_id'], $data['previous_role'], $data['new_role'], $data['date'], $data['owner_email'], $data['user_email'], $data['owner_name'], $data['user_name']);
        }

        $stmt->close();

        return $logs;
    }

    public function getLogsByUserEmail(string $email): ?array
    {
        $db = $this->db;

        $email = $db->real_escape_string($email);

        $sql = "SELECT user_management.*, owner.email as owner_email, owner.name as owner_name, user.email as user_email, user.name as user_name FROM user_management
        INNER JOIN users as owner ON user_management.owner_id = owner.id 
        INNER JOIN users as user ON user_management.user_id = user.id  
        WHERE user.email = ?
        ORDER BY date DESC";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('s', $email);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $raw_data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $logs = [];
        foreach ($raw_data as $data) {
            $logs[] = new UserManagementLog($data['owner_id'], $data['user_id'], $data['previous_role'], $data['new_role'], $data['date'], $data['owner_email'], $data['user_email'], $data['owner_name'], $data['user_name']);
        }

        $stmt->close();

        return $logs;
    }
}
