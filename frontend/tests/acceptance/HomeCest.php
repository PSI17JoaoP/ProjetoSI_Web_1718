<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage('site/signup');

        $I->submitForm('#signup-form', [
            'SignupForm[username]' => 'testerExample8',
            'SignupForm[email]' => 'tester.email8@example.com',
            'SignupForm[password]' => 'tester_password',
            'SignupForm[checkPassword]'  => 'tester_password',
        ]);

        $I->wait(5);
        
        $I->see('Criar Anúncio');

        $I->click('Criar Anúncio');
        $I->wait(5);

        $I->see('Adicionar informações de conta');

        $I->fillField('#clienteform-nomecompleto', "Teste exemplo");
        $I->wait(1);
        $I->appendField('#clienteform-datanasc', '10-10-2000');
        $I->wait(1);
        $I->fillField('#clienteform-telefone', "912365478");
        $I->wait(1);

        $I->click('Guardar');

        $I->wait(5);
    }
}
