<?php

namespace App\Models\Classes;


use App\Models\Classes\DeliveryData;

/**
 * The User class represents a user in the system.
 */
class User
{
    /**
     * Create a new User instance.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @param string|null $username The user's username (optional).
     * @param string|null $role The user's role (optional).
     * @param string|null $id The user's ID (optional).
     */
    public function __construct(
        protected string $email,
        protected string $password,
        protected ?string $name = '',
        protected ?string $role = null,
        protected ?string $id = '',
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->role = $role;
        $this->id = $id;
    }
}
