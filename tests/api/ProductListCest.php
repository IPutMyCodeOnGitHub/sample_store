<?php

use Codeception\Util\HttpCode;

class ProductListCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/catalog/products');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'description' => 'string',
            'category' => [
                "id" => "string",
                'name' => 'string'
            ],
            'price' => 'float'
        ]);
    }
}
