<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\NotUniqueCardnameException;
use App\Repository\CardRepository;

class CardDataValidator
{
    public function __construct(private CardRepository $cardRepository)
    {
    }

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
        return $stat >= 0;
    }

    public function ensureNameIsUnique(string $name): void
    {
        if ($this->cardRepository->findOneByName($name)) {
            throw new NotUniqueCardnameException('Card name already exists!');
        }
    }
}
