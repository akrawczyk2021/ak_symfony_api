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
        $cardid = $I->haveInDatabase('Card', ['name' => 'Goblin', 'description' => 'Low lvl', 'attack' => 1, 'defense' => 1, 'hp' => 1]);

        $I->sendDelete('card/' . $cardid);

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testItThrowsErrorWhenCardNotFound(ApiTester $I)
    {
        $I->sendDelete('card/21421');

        $I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}
