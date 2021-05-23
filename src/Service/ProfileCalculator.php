<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\MatchSummary;
use App\DTO\PlayerProfile;

class ProfileCalculator
{
    public function calculateByMatch(PlayerProfile $profile, MatchSummary $matchSummary): PlayerProfile
    {
        $this->ensureValidMatchSummary($matchSummary);

        return new PlayerProfile(
            $this->calculateVictories($profile, $matchSummary),
            $this->increaseMatchesPlayed($profile),
            $this->calculateKills($profile, $matchSummary)
        );
    }

    private function ensureValidMatchSummary(MatchSummary $matchSummary): void
    {
        if ($matchSummary->getKills() < 0) {
            throw new \RuntimeException('Invalid match summary!');
        }
    }

    private function calculateVictories(PlayerProfile $profile, MatchSummary $matchSummary): int
    {
        $victories = $profile->getVictories();
        if ($matchSummary->isWin()) {
            $victories++;
        }

        return $victories;
    }

    private function increaseMatchesPlayed(PlayerProfile $profile): int
    {
        return $profile->getMatchesPlayed() + 1;
    }

    private function calculateKills(PlayerProfile $profile, MatchSummary $matchSummary): int
    {
        return $profile->getKills() + $matchSummary->getKills();
    }
}
