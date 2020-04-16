<?php

use Codeception\Util\HttpCode;

class AddCartItemCest
{
    public function _before(ApiTester $I)
    {
        $I->amAuthenticated('user_1@mail.com', '123456');
    }

    public function tryToTest(ApiTester $I)
    {
        $productId = '2';
        $I->sendPOST('/my/cart/products/' . $productId);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'product' => [
                'id' => 'string',
                'name' => 'string'
            ],
            'quantity' => 'integer',
            'price' => 'float',
            'cart' => [
                'id' => 'integer'
            ]
        ]);
        $I->seeResponseContainsJson(["id" => $productId]);
    }
}
