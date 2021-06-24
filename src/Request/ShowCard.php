<?php

declare(strict_types=1);

namespace App\Request;

class ShowCard
{
    public function __construct(
        private int $cardId,
    ) {
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }
}
