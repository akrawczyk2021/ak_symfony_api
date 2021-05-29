<?php

declare(strict_types=1);

namespace App\DTO;

class MatchSummary
{
    public function __construct(
        private int $kills,
        private bool $win,
    ) {
    }

    public function getKills(): int
    {
        return $this->kills;
    }

    public function isWin(): bool
    {
        return $this->win;
    }
}
