<?php

declare(strict_types=1);

namespace App\Validator;

class UserDataValidator
{
    const PATTERN = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/';
    const EMAILPATTERN = '/(?=.*[a-zA-Z])(?=.*[\.])(?=.*[\@])/';

    public function isValidName(string $name): bool
    {
        $hasSpaces = strpos($name, ' ');
        $hasSpecialChars = strpos($name, '!');

        return !empty($name) && !$hasSpaces && !$hasSpecialChars;
    }

    public function isValidEmail(string $email): bool
    {
        $isCorrectEmailFormat = preg_match(self::EMAILPATTERN, $email) === 1;

        return !empty($email) && $isCorrectEmailFormat;
    }

    public function isValidPassword(string $password): bool
    {
        $isCorrectPasswordFormat = preg_match(self::PATTERN, $password) === 1;

        return !empty($password) && $isCorrectPasswordFormat;
    }
}
