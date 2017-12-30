<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;


class ContaCest
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

        $I->submitForm('#login-form',  [
            'LoginForm[username]' => 'erao',
            'LoginForm[password]' => 'password_0',
        ]);
    }

    public function checkConta(FunctionalTester $I)
    {
        $I->amOnPage('site/url');
        $I->see('Sistema de Trocas');

        $I->see('erao');
        $I->click('erao');
        $I->see('Definições');
        $I->click('Definições');

        $I->submitForm('#conta-form', [
            'ClienteForm[nomeCompleto]' => 'NomeTeste',
            'ClienteForm[telefone]' => '912365478',
            'ClienteForm[dataNasc]' => '2000-12-12',
            'ClienteForm[regiao]' => 'leiria',
        ]);

        $I->see('Sucesso! As suas informações de conta foram atualizadas com sucesso.');
        
    }
}