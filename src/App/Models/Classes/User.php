<?php

namespace App\Models\Abstract;


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
     * @param DeliveryData|null $delivery_data The user's delivery data (optional).
     */
    public function __construct(
        protected string $email,
        protected string $password,
        protected ?string $username = '',
        protected ?string $role = null,
        protected ?string $id = '',
        protected ?DeliveryData $delivery_data = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->role = $role;
        $this->id = $id;
        $this->delivery_data = $delivery_data;
    }
}
