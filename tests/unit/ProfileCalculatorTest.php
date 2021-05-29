<?php

namespace App\Tests;

use App\DTO\MatchSummary;
use App\DTO\PlayerProfile;
use App\Service\ProfileCalculator;
use Codeception\Test\Unit;

class ProfileCalculatorTest extends Unit
{
    protected UnitTester $tester;

    public function testDefeatFirstMatch(): void
    {
        $profile = new PlayerProfile(0, 0, 0);
        $lastMatchResult = new MatchSummary(5, false);

        $subject = new ProfileCalculator();

        $resultProfile = $subject->calculateByMatch($profile, $lastMatchResult);

        $this->assertEquals(1, $resultProfile->getMatchesPlayed());
        $this->assertEquals(0, $resultProfile->getVictories());
        $this->assertEquals(5, $resultProfile->getKills());
    }

    public function testWinSecondMatchWithTenKills(): void
    {
        $profile = new PlayerProfile(0, 1, 0);
        $lastMatchResult = new MatchSummary(10, true);

        $subject = new ProfileCalculator();

        $resultProfile = $subject->calculateByMatch($profile, $lastMatchResult);

        $this->assertEquals(2, $resultProfile->getMatchesPlayed());
        $this->assertEquals(1, $resultProfile->getVictories());
        $this->assertEquals(10, $resultProfile->getKills());
    }

    public function testInvalidMatchSummary(): void
    {
        $profile = new PlayerProfile(0, 1, 0);
        $lastMatchResult = new MatchSummary(-10, true);

        $subject = new ProfileCalculator();

        $this->expectException(\RuntimeException::class);

        $subject->calculateByMatch($profile, $lastMatchResult);
    }
}
