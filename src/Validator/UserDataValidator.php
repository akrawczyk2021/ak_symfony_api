<?php

declare(strict_types=1);

namespace App\Validator;

class UserDataValidator
{
    const PATTERN = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/';
    const EMAILPATTERN = '/(?=.*[a-zA-Z])(?=.*[\.])(?=.*[\@])/';

    public function isValidName(string $name): bool
    {
        return !empty($name);
    }

    public function isValidEmail(string $email): bool
    {
        return !empty($email) && preg_match(self::EMAILPATTERN, $email) === 1;
    }

    public function isValidPassword(string $password): bool
    {
        return !empty($password) && preg_match(self::PATTERN, $password) === 1;
    }
}
