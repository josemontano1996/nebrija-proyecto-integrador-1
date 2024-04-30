<?php

declare(strict_types=1);

namespace App;

use App\Models\Classes\User;

class AuthSession
{

    private string $user_id;
    private string $user_name;
    private ?string $user_role = null;

    /**
     * AuthSession constructor.
     *
     * @param User $user The user to save in the session.
     */
    public function __construct(User $user)
    {
        $this->user_id = $user->getId();
        $this->user_name = $user->getName();
        $this->user_role = $user->getRole();
    }


    /**
     * Save the user ID and role to the session.
     */
    public function save(): void
    {
        $_SESSION['user']['id'] = $this->user_id;
        $_SESSION['user']['name'] = $this->user_name;
        $_SESSION['user']['role'] = $this->user_role;
    }
    /**
     * Checks if a user is logged in.
     *
     * @return bool Returns true if a user is logged in, false otherwise.
     */
    static public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Get the user ID from the session.
     *
     * @return string|null The user ID, or null if not set.
     */
    static public function getUserId(): ?string
    {
        return $_SESSION['user']['id'] ?? null;
    }


    /**
     * Get the user name from the session.
     *
     * @return string|null The user name, or null if not set.
     */
    static public function getUserName(): ?string
    {
        return $_SESSION['user']['name'] ?? null;
    }
    /**
     * Get the user role from the session.
     *
     * @return string|null The user role, or null if not set.
     */
    static public function getUserRole(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    static public function isUserRole(string $role): bool
    {
        return $_SESSION['user']['role'] === $role;
    }

    /**
     * Destroy the session.
     */
    static public function destroy(): void
    {
        $_SESSION['user'] = null;
    }
}
