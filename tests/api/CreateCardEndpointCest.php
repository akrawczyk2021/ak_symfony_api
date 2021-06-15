<?php

namespace App\Tests;

use App\Entity\Card;
use Codeception\Util\HttpCode;

class CreateCardEndpointCest
{
    public function testItCreatesCard(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => 'Goblin',
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeInRepository(
            Card::class,
            [
                'name' => 'Goblin',
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );
    }

    public function testItThrowBadRequestWithNotUniqueName(ApiTester $I)
    {
        $I->haveInRepository(
            $existedCard = new Card(
                'Goblin',
                1,
                1,
                1,
            )
        );

        $I->sendPost(
            '/card',
            [
                'name' => $existedCard->getName(),
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowBadRequestWithSpaceInName(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => "test space",
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowBadRequestWithNegativeStatValue(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => "Monster",
                'description' => 'Low level monster',
                'hp' => 10,
                'attack' => -1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowBadRequestWithEmptyStatValue(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => "Monster",
                'description' => 'Low level monster',
                'hp' => null,
                'attack' => -1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowBadRequestWithEmptyName(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => "",
                'description' => 'Low level monster',
                'hp' => 1,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testItThrowBadRequestWithEmptyDescription(ApiTester $I)
    {
        $I->sendPost(
            '/card',
            [
                'name' => "Monster",
                'description' => '',
                'hp' => 1,
                'attack' => 1,
                'defense' => 1,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
