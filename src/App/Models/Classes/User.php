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

    /**
     * Get the user's email address.
     *
     * @return string The user's email address.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the user's password.
     *
     * @return string The user's password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the user's name.
     *
     * @return string|null The user's name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the user's role.
     *
     * @return string|null The user's role.
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Get the user's ID.
     *
     * @return string|null The user's ID.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
