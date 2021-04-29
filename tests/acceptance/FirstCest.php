<?php
namespace App\Tests;
use App\Tests\AcceptanceTester;
class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests

    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('SYMFONY');
    }
    public function tryToTest(AcceptanceTester $I)
    {
    }
}
