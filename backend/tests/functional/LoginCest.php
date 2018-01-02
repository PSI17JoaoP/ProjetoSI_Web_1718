<?php

namespace backend\tests\functional;

use \backend\tests\FunctionalTester;
use common\fixtures\UserFixture as UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
    
    }
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->am('guest');
        $I->amOnPage('/site/login');
        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('Login');

        $I->see('Dashboard - Back Office');
    }
}
