<?php

declare(strict_types=1);

namespace App\Validator;


class CardDataValidator
{
    public function isValidName(string $name): bool
    {
        $hasSpaces = strpos($name, ' ');
        $hasSpecialChars = strpos($name, '!');

        return !empty($name) && !$hasSpaces && !$hasSpecialChars;
    }

    public function isValidDescription(string $description): bool
    {
        return !empty($description);
    }

    public function isValidIntStat(int $stat): bool
    {
        $isCorrectType = is_int($stat);

        return !empty($attack) && $isCorrectType;
    }
    
    
}
