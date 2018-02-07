<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class SignupCest
{
    protected $formId = '#signup-form';


    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/signup'));
    }

    public function signupWithEmptyFields(AcceptanceTester $I)
    {
        $I->see('Registo', 'h3');
        $I->submitForm($this->formId, []);
        $I->wait(5);
        $I->see('“Nome do utilizador” não pode ficar em branco.');
        $I->see('“Palavra-passe” não pode ficar em branco.');
        $I->see('“Verificar Palavra-passe” não pode ficar em branco.');
        $I->see('“Email” não pode ficar em branco.');

    }

    public function signupWithWrongEmail(AcceptanceTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'testerExample13',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
            'SignupForm[checkPassword]'  => 'tester_password',
        ]
        );
        $I->wait(5);
        $I->dontSee('“Nome do utilizador” não pode ficar em branco.', '.help-block');
        $I->dontSee('“Palavra-passe” não pode ficar em branco.', '.help-block');
        $I->dontSee('“Verificar Palavra-passe” não pode ficar em branco.', '.help-block');
        $I->see('“Email” não é um endereço de e-mail válido.', '.help-block');
    }

    public function signupSuccessfully(AcceptanceTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'testerExample13',
            'SignupForm[email]' => 'tester.email13@example.com',
            'SignupForm[password]' => 'tester_password',
            'SignupForm[checkPassword]'  => 'tester_password',
        ]);

        $I->wait(5);
        $I->seeRecord('common\models\User', [
            'username' => 'testerExample13',
            'email' => 'tester.email13@example.com',
        ]);
        
        $I->see('Criar Anúncio');
    }
}
