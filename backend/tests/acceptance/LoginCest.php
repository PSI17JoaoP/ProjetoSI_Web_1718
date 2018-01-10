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
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('Login');

        $I->fillField('#loginform-username', 'erau');
        $I->wait(2);
        $I->fillField('#loginform-password', 'password_0');
        $I->wait(2);
        $I->click('Login');
        $I->wait(5); 

        $I->see('Dashboard - Back Office');

        $I->click('Todos');
        $I->wait(2);
        $I->click('Anúncios');
        $I->wait(2);
        $I->click('Propostas');
        $I->wait(2);
        $I->click('Utilizadores');
        $I->wait(5);
    }
}