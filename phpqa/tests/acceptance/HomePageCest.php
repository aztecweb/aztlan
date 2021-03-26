<?php

class HomePageCest
{
    public function tryToTest(AcceptanceTester $I) : void
    {
        $I->amOnPage('/');
        $I->see('Welcome to Aztlan');
    }
}
