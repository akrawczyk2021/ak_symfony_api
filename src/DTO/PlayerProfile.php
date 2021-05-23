<?php

declare(strict_types=1);

namespace App\DTO;

class PlayerProfile
{
    public function __construct(
        private int $victories,
        private int $matchesPlayed,
        private int $kills,
    ) {
    }

    public function getVictories(): int
    {
        return $this->victories;
    }

    public function getMatchesPlayed(): int
    {
        return $this->matchesPlayed;
    }

    public function getKills(): int
    {
        return $this->kills;
    }
}