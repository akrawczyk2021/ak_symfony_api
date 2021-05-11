<?php

declare(strict_types=1);

namespace App\Request;

class CreateUser
{
    public string $name;
    public string $email;
    public string $password;
}
