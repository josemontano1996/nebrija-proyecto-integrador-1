<?php

declare(strict_types=1);

namespace App\Controllers\User;

use App\View;

class UserController
{
    public function index(): string
    {
        return (new View('user/user'))->render();
    }
}
