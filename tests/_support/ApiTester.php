<?php

use Codeception\Util\HttpCode;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    public function amAuthenticated(string $username, string $password)
    {
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendPOST('/auth/login_check',
            '{"username":"' . $username . '",
              "password":"' . $password .'"}'
        );
        $this->seeResponseCodeIs(HttpCode::OK);
        $response = json_decode($this->grabResponse());

        $this->amBearerAuthenticated($response->token);
        $this->haveHttpHeader('Content-Type', 'application/json');
    }
}
