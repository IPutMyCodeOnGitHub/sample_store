<?php

use Codeception\Util\HttpCode;

class ShowProductCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function tryToTest(ApiTester $I)
    {
        $productId = 1;
        $I->sendGET('/catalog/products/' . $productId);
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
        $I->seeResponseContainsJson(["id" => $productId]);
    }
}
