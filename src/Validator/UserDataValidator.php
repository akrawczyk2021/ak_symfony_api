<?php

declare(strict_types=1);

namespace App\Validator;

class UserDataValidator
{
    const PATTERN = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/';

    public function isValidName(string $name): bool
    {
        if (empty($name)) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidEmail(string $email): bool
    {
        if (empty($email)) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidPassword(string $password): bool
    {
        if (empty($password) && preg_match(self::PATTERN, $password) == 1) {
            return false;
        } else {
            return true;
        }
    }

}
