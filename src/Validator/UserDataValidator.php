<?php

declare(strict_types=1);

namespace App\Validator;

class UserDataValidator
{
    public function isValidName(string $name): bool
    {
        return false;
    }

    public function isValidEmail(string $email): bool
    {
        return false;
    }

    public function isValidPassword(string $password): bool
    {
        return false;
    }
}
