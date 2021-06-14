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
}
