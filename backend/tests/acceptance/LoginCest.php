<?php
namespace backend\tests\acceptance;

use backend\tests\AcceptanceTester;
use yii\helpers\Url;
use common\fixtures\UserFixture as UserFixture;


class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
    
    }

    public function checkLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');
        $I->see('Login');

        $I->fillField('#loginform-username', 'admin');
        $I->wait(2);
        $I->fillField('#loginform-password', '123456');
        $I->wait(2);
        $I->click('Login');
        $I->wait(5); 

        $I->see('Dashboard - Back Office');

    }
}
