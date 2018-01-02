<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture as UserFixture;


class PerfilCest
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

    public function checkPerfil(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->see('Login');

        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('Login');

        $I->see('Dashboard - Back Office');

        $I->click('erau');
        $I->click('Perfil');

        $I->see("Editar dados pessoais");

        $I->fillField('#perfilform-username', 'Erau2');
        $I->fillField('#perfilform-email', 'erau@erau.pt');
        $I->fillField('#perfilform-password', 'password_0');

        $I->click('Concluído');
        $I->see('Erau2');
        $I->see('Gestão de Utilizadores');
    }
}
