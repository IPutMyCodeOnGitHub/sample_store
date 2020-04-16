<?php

use Codeception\Util\HttpCode;

class ShowOrderCest
{
    public function _before(ApiTester $I)
    {
        $I->amAuthenticated('user_1@mail.com', '123456');
    }

    public function tryToTest(ApiTester $I)
    {
        $orderId = 1;
        $I->sendGET('/my/orders/' . $orderId);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'address' => 'string',
            'created_at' => 'string',
            'status' => 'integer',
            'customer' => [
                "id" => "integer"
            ],
            'items' => [ [
                'id' => 'string',
                'product' => [
                    'id' => 'string',
                    'name' => 'string'
                ]
            ]
            ],
            'comment' => 'string|null'
        ]);
        $I->seeResponseContainsJson(["id" =>$orderId]);
    }
}
