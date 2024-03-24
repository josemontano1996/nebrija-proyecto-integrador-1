<?php

declare(strict_types=1);

namespace App\Controllers\User;

require_once __DIR__ .  '/../../../lib/data-validation.php';

use App\Models\AddressModel;
use App\View;

class UserController
{
    public function index(): string
    {
        return (new View('user/user'))->render();
    }
}
