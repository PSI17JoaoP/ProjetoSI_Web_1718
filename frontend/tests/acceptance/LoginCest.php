<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use common\fixtures\UserFixture;

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
        $I->amOnPage('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->wait(5);
        $I->see('“Nome do utilizador” não pode ficar em branco.');
        $I->see('“Palavra-passe” não pode ficar em branco.');
    }

    public function checkWrongPassword(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'wrong'));
        $I->wait(5);
        $I->see('A palavra-passe está incorreta.');
    }

    public function checkWrongUsername(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('teste', 'wrong'));
        $I->wait(5);
        $I->see('Este utilizador não existe ou está bloqueado.');
    }
    
    public function checkValidLogin(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'password_0'));
        $I->wait(5);
        $I->see('erao');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Registo');
    }
}
