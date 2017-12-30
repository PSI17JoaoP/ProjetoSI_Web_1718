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
        $I->amOnRoute('site/login');
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
        $I->seeValidationError('“Nome do utilizador” não pode ficar em branco.');
        $I->seeValidationError('“Palavra-passe” não pode ficar em branco.');
    }

    public function checkWrongPassword(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'wrong'));
        $I->seeValidationError('A palavra-passe está incorreta.');
    }

    public function checkWrongUsername(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('teste', 'wrong'));
        $I->seeValidationError('Este utilizador não existe.');
    }
    
    public function checkValidLogin(AcceptanceTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'password_0'));
        $I->see('erao');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Registo');
    }
}
