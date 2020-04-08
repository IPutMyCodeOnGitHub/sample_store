<?php

use Codeception\Util\HttpCode;

class ShowCartItemsCest
{
    public function _before(ApiTester $I)
    {
        $I->amAuthenticated('user_1@mail.com', '123456');
    }

    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/my/cart');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'customer' => [
                "id" => "integer"
            ],
            'status' => 'integer',
            'items' => [ [
                'id' => 'integer',
                'product' => [
                    'id' => 'string',
                    'name' => 'string'
                ],
                'quantity' => 'integer',
                'price' => 'float'
            ]
            ],
        ]);
    }
}
