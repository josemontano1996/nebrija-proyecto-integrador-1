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

   
}
