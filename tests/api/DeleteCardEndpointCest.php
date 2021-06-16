<?php

namespace App\Tests;

use App\Tests\ApiTester;
use App\Entity\Card;
use Codeception\Util\HttpCode;

class DeleteCardEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testItDeleteCard(ApiTester $I)
    {
        $I->haveInRepository(
            $existedCard = new Card(
                'Goblin',
                1,
                1,
                1,
            )
        );

        $I->sendDelete('card/Goblin');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testItThrowsErrorWhenCardNotFound(ApiTester $I)
    {
        $I->haveInRepository(
            $existedCard = new Card(
                'Goblin',
                1,
                1,
                1,
            )
        );

        $I->sendDelete('card/a b c');
        $I->dontSeeResponseCodeIs(HttpCode::OK);
    }
}
