<?php

use Codeception\Util\HttpCode;

class CustomerProfileCest
{
    public function _before(ApiTester $I)
    {
        $I->amAuthenticated('user_1@mail.com', '123456');
    }

    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/my/profile');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'username' => 'string',
            'email' => 'string',
            'id' => 'integer'
        ]);
        $I->seeResponseContainsJson(["username" =>"user_1@mail.com"]);
    }
}
