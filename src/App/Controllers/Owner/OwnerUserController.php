<?php

namespace App\Controllers\Owner;

use App\Models\UserManagementModel;
use App\Models\UserModel;
use App\View;

class OwnerUserController
{
    public function getUsers(): string
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $users = UserModel::getAllUsers($page, 20);

        $alphabeticalUsers = UserModel::sortUsersAlphabeticallyByEmail($users);

        return (new View('owner/users', [$alphabeticalUsers, $page]))->render();
    }

    public function searchUser(): string
    {
        $email = urldecode($_GET['email']) ?? '';

        $user = UserModel::getUserByEmail($email);

        if (!$user) {
            $_SESSION['error'] = 'User not found';
            http_response_code(404);
            header('Location: /owner/users');
            exit();
        }


        return (new View('owner/user', [$user]))->render();
    }

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
}
