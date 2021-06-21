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
        $cardid = $I->haveInDatabase('Card', ['name' => 'GoblinTest', 'description' => 'Low lvl', 'attack' => 1, 'defense' => 1, 'hp' => 1]);

        $I->sendGet('card/' . $cardid);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testItThrowErrorWhenWrongId(ApiTester $I)
    {
        $I->sendGet('card/523435');

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}
