<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SignupCest
{
    protected $formId = '#signup-form';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Registo', 'h3');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('“Nome do utilizador” não pode ficar em branco.');
        $I->seeValidationError('“Palavra-passe” não pode ficar em branco.');
        $I->seeValidationError('“Verificar Palavra-passe” não pode ficar em branco.');
        $I->seeValidationError('“Email” não pode ficar em branco.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
            'SignupForm[checkPassword]'  => 'tester_password',
        ]
        );
        $I->dontSee('“Nome do utilizador” não pode ficar em branco.', '.help-block');
        $I->dontSee('“Palavra-passe” não pode ficar em branco.', '.help-block');
        $I->dontSee('“Verificar Palavra-passe” não pode ficar em branco.', '.help-block');
        $I->see('“Email” não é um endereço de e-mail válido.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'testerExample',
            'SignupForm[email]' => 'tester.email@example.com',
            'SignupForm[password]' => 'tester_password',
            'SignupForm[checkPassword]'  => 'tester_password',
        ]);

       
        $I->seeRecord('common\models\User', [
            'username' => 'testerExample',
            'email' => 'tester.email@example.com',
        ]);
        

        $I->see('Criar Anúncio');
    }
}
