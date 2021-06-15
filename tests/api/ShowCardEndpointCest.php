<?php

namespace App\Tests;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;
use App\Entity\Card;

class ShowCardEndpointCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testItShowsCardDetails(ApiTester $I)
    {
        $I->haveInRepository(
            $existedCard = new Card(
                'Goblin',
                1,
                1,
                1,
            )
        );
        $I->sendGet('card/Goblin');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testItThrowErrorWhenWrogName(ApiTester $I)
    {
        $I->sendGet('card/a b c');
        $I->dontseeResponseCodeIs(HttpCode::OK);
    }
}
