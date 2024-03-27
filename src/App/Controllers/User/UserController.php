<?php

declare(strict_types=1);

namespace App\Controllers\User;

require_once __DIR__ .  '/../../../lib/validation.php';

use App\Models\UserModel;
use App\View;

class UserController
{
    public function getUserAccount(): string
    {

        $userId = $_SESSION['user']['id'];

        $user = UserModel::getUserById($userId);

        if (!$user) {
            $_SESSION['error'] = 'Error while fecching user data. Please try again later.';
            http_response_code(500);
            header('Location: /');
            exit();
        }

        return (new View('user/account', [$user]))->render();
    }

    public function updateUserAccount(): void
    {

        $user_name = $_POST['username'] ? trim($_POST['username']) : '';
        $email = $_POST['email'] ? trim($_POST['email']) : '';
        $password = $_POST['password'] ? trim($_POST['password']) : null;
        $confirm_password = $_POST['confirm_password'] ? trim($_POST['confirm_password']) : null;

        if (!isValidString($user_name, 2)) {
            $_SESSION['error'] = 'Invalid username format';
            header('Location: /user/account');
            exit();
        }
        if (!isValidEmail($email)) {
            $_SESSION['error'] = 'Invalid email format';
            header('Location: /user/account');
            exit();
        }

        if (isset($password) && (!isValidString($password, 8) || !isValidString($confirm_password, 8))) {
            $_SESSION['error'] = 'Password must be at least 8 characters long';
            header('Location: /user/account');
            exit();
        }

        if ($confirm_password !== $password) {
            $_SESSION['error'] = 'Passwords do not match';
            header('Location: /user/account');
            exit();
        }

        $userId = $_SESSION['user']['id'];

        $result = UserModel::updateUser($userId, $user_name, $email, $password);

        if (!$result) {
            $_SESSION['error'] = 'Error while updating user data. Please try again later.';
            http_response_code(500);
            header('Location: /');
            exit();
        }

        $_SESSION['success'] = 'User data updated successfully';
        header('Location: /user/account');
    
    }
}
