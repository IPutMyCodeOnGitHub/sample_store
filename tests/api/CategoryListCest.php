<?php

use Codeception\Util\HttpCode;

class CategoryListCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/catalog/categories');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'products' => [
                [
                'id' => 'string'
                ]
            ]
        ]);
    }
}
