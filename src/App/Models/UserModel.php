<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Classes\User;
use App\DAO\UserDAO;

/**
 * Class UserModel
 * 
 * Represents a user model that extends the User class.
 */
class UserModel extends User
{

    /**
     * UserModel constructor.
     *
     * @param string $email The user's email.
     * @param string $password The user's password.
     * @param string|null $name The user's name (optional).
     * @param string|null $role The user's role (optional).
     * @param string|null $id The user's ID (optional).
     */
    public function __construct(
        string $email,
        string $password,
        ?string $name = '',
        ?string $role = '',
        ?string $id = '',
    ) {
        parent::__construct($email, $password, $name, $role, $id);
    }

    /**
     * Registers the user in the database.
     *
     * @return bool Returns true if the user is successfully registered, false otherwise.
     */
    public function register(): bool
    {
        $userDAO = new UserDAO();
        $registerSuccesfull = $userDAO->registerUser($this->name, $this->email, $this->password);

        return $registerSuccesfull;
    }

    /**
     * Performs a login operation for the user.
     *
     * @return array|null Returns an array containing the user data if login is successful, otherwise returns null.
     */
    public function login(): ?array
    {
        // Retrieve user data from the database
        $userDAO = new UserDAO();
        $userData = $userDAO->getUserByEmail($this->email);

        if (!$userData) {
            return null;
        }

        // Initialize the user data to null
        $user = null;

        // Check if the passwords match
        if (password_verify($this->password, $userData['password'])) {
            $user = $userData;
        }

        return $user;
    }

    /**
     * Retrieves user data by ID.
     *
     * @param string $userId The ID of the user.
     * @return array|null Returns an array containing the user data if found, otherwise returns null.
     */
    static public function getUserById(string $userId): ?array
    {
        $userDAO = new UserDAO();
        $userData = $userDAO->getUserById($userId);

        return $userData;
    }

    /**
     * Updates user data.
     *
     * @param string $userId The ID of the user.
     * @param string $name The new name of the user.
     * @param string $email The new email of the user.
     * @param string|null $password The new password of the user (optional).
     * @return bool Returns true if the user data is successfully updated, false otherwise.
     */
    static public function updateUser(string $userId, string $name, string $email, ?string $password): bool
    {
        $userDAO = new UserDAO();
        $updateSuccesfull = $userDAO->updateUser($userId, $name, $email, $password);

        return $updateSuccesfull;
    }
}
