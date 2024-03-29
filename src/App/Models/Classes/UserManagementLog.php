<?php

namespace App\Models\Classes;

class UserManagementLog
{
      public function __construct(protected string $owner_id, protected string $user_id, protected string $previous_role, protected string $new_role, protected string $date, protected ?string $owner_email = null, protected ?string $user_email = null, protected ?string $owner_name = null, protected ?string $user_name = null)
    {
        $this->owner_id = $owner_id;
        $this->user_id = $user_id;
        $this->previous_role = $previous_role;
        $this->new_role = $new_role;
        $this->date = $date;
        $this->owner_email = $owner_email;
        $this->user_email = $user_email;
        $this->owner_name = $owner_name;
        $this->user_name = $user_name;
    }

    public function getOwnerId(): string
    {
        return $this->owner_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getPreviousRole(): string
    {
        return $this->previous_role;
    }

    public function getNewRole(): string
    {
        return $this->new_role;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getOwnerEmail(): ?string
    {
        return $this->owner_email;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function getOwnerName(): ?string
    {
        return $this->owner_name;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }
}
