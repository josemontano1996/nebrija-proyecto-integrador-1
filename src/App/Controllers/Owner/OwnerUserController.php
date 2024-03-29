<?php

namespace App\Controllers\Owner;

use App\Models\UserModel;
use App\View;

class OwnerUserController
{
    public function getUsers(): string
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        try {

            $users = UserModel::getAllUsers($page, 20);

            if (!$users) {
                $_SESSION['error'] = 'No users found';
                http_response_code(404);
                header('Location: /owner/users');
                exit();
            }

            $alphabeticalUsers = UserModel::sortUsersAlphabeticallyByEmail($users);

            return (new View('owner/users', [$alphabeticalUsers, $page]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            http_response_code(500);
            header('Location: /');
            exit();
        }
    }

    public function searchUser(): string
    {
        $email = urldecode($_GET['email']) ?? '';
        try {

            $user = UserModel::getUserByEmail($email);

            if (!$user) {
                $_SESSION['error'] = 'User not found';
                http_response_code(404);
                header('Location: /owner/users');
                exit();
            }


            return (new View('owner/user', [$user]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            http_response_code(500);
            header('Location: /');
            exit();
        }
    }
}
