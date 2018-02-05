<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

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

        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('“Nome do utilizador” não pode ficar em branco.');
        $I->seeValidationError('“Palavra-passe” não pode ficar em branco.');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'wrong'));
        $I->seeValidationError('A palavra-passe está incorreta.');
    }

    public function checkWrongUsername(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('teste', 'wrong'));
        $I->seeValidationError('Este utilizador não existe ou está bloqueado.');
    }
    
    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('erao', 'password_0'));
        $I->see('erao');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Registo');
    }
}
