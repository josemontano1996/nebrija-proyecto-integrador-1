<?php

declare(strict_types=1);

namespace App\Models;

use App\Classes\DeliveryData;
use App\Classes\User;
use App\DAO\UserDAO;
use App\DB;
use mysqli;
use mysqli_result;

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
     * @param string|null $username The user's username (optional).
     * @param string|null $role The user's role (optional).
     * @param string|null $id The user's ID (optional).
     * @param DeliveryData|null $delivery_data The user's delivery data (optional).
     */
    public function __construct(
        string $email,
        string $password,
        ?string $username = '',
        ?string $role = '',
        ?string $id = '',
        ?DeliveryData $delivery_data = null
    ) {
        parent::__construct($email, $password, $username, $role, $id, $delivery_data);
    }

    /**
     * Registers the user in the database.
     *
     * @return mysqli_result|null Returns true if the user is successfully registered, false otherwise.
     */
    public function register(): bool
    {
        $userDAO = new UserDAO();
        $registerSuccesfull = $userDAO->registerUser($this->username, $this->email, $this->password);

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
        $userData = $userDAO->getUserByEmail($this->email, $this->password);

        if (!$userData) {
            return null;
        }

        // Initialize the user data to null
        $user = null;

        // Check if the passwords match
        if (password_verify($this->password, $userData['password'])) {

            // Assign user ID
            $user['id'] = $userData['id'];
            // Assign user role if it exists
            if (!empty($userData['role'])) {
                $user['role'] = $userData['role'];
            }
        }

        return $user;
    }
}
