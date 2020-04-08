<?php

use App\Entity\Order;
use Codeception\Util\HttpCode;

class CreateOrderCest
{
    public function _before(ApiTester $I)
    {
        $I->amAuthenticated('user_1@mail.com', '123456');
    }

    public function tryToTest(ApiTester $I)
    {
        $address = "street";
        $phoneNumber = "966969696";
        $comment = "some comment";
        $I->sendPOST('/my/orders', [
	        "address" => $address,
	        "phone_number" => $phoneNumber,
	        "comment" => $comment
            ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'address' => 'string',
            'phone_number' => 'string',
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
            'comment' => 'string'
        ]);
        $I->seeResponseContainsJson(["address" => $address]);
        $I->seeResponseContainsJson(["phone_number" => $phoneNumber]);
        $I->seeResponseContainsJson(["comment" => $comment]);
    }
}
