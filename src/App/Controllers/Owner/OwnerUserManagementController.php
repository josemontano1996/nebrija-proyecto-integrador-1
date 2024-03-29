<?php

namespace App\Controllers\Owner;

use App\Models\UserManagementModel;
use App\View;

class OwnerUserManagementController
{
    public function updateUserRole(): void
    {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $role = isset($_POST['role']) ? $_POST['role'] : null;

        if (!isset($email)) {
            $_SESSION['error'] = 'User email required';
            header('Location: /owner/users');
            exit();
        }

        $urlEncodedEmail = urlencode($email);

        if (!$user_id) {
            $_SESSION['error'] = 'User ID required';
            header('Location: /owner/user/search?email=' . $urlEncodedEmail);
            exit();
        }

        if ($role && ($role !== 'owner' && $role !== 'admin')) {
            $_SESSION['error'] = 'Invalid role';
            http_response_code(400);
            header('Location: /owner/user/search?email=' . $urlEncodedEmail);
            exit();
        }

        $owner_id = $_SESSION['user']['id'];

        try {
            $updateSuccessful = UserManagementModel::updateUserRole($owner_id, $user_id, $role);

            if (!$updateSuccessful) {
                $_SESSION['error'] = 'Failed to update user role';
                http_response_code(500);
                header('Location: /owner/user/search?email=' . $urlEncodedEmail);
                exit();
            }

            $_SESSION['success'] = 'User role updated successfully';
            header('Location: /owner/user/search?email=' . $urlEncodedEmail);
            exit();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            http_response_code(500);
            header('Location: /owner/users');
            exit();
        }
    }


    public function getManagementLogs(): string
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        try {

            $logs = UserManagementModel::getManagementLogs($page, 20);

            if (!$logs) {
                $_SESSION['error'] = 'No logs found';
                http_response_code(404);
                header('Location: /owner/users');
                exit();
            }

            return (new View('owner/user-management-logs', [$logs, $page]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            http_response_code(500);
            header('Location: /');
            exit();
        }
    }

    public function getLogsByUserEmail(): string
    {
        $email = urldecode($_GET['email']) ?? '';
        try {

            $logs = UserManagementModel::getLogsByUserEmail($email);
            if (!$logs) {

                $_SESSION['error'] = 'No logs found';
                http_response_code(404);
                header('Location: /owner/user/management');
                exit();
            }
            return (new View('owner/logs-user', [$logs, $email]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            http_response_code(500);
            header('Location: /');
            exit();
        }
    }
}
