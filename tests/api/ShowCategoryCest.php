<?php

use Codeception\Util\HttpCode;

class ShowCategoryCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function tryToTest(ApiTester $I)
    {
        $categoryId = 1;
        $I->sendGET('/catalog/categories/' . $categoryId);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string',
            'name' => 'string',
            'category' => [
                'name' => 'string'
            ],
            'price' => 'float'
        ]);
    }
}
