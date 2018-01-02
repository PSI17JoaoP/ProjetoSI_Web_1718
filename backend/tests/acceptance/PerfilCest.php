<?php
namespace backend\tests\acceptance;

use backend\tests\AcceptanceTester;
use yii\helpers\Url;
use common\fixtures\UserFixture as UserFixture;


class PerfilCest
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

    public function checkPerfil(AcceptanceTester $I)
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

        $I->click('erau');
        $I->wait(2);
        $I->click('Perfil');
        $I->wait(5);

        $I->see("Editar dados pessoais");

        $I->fillField('#perfilform-username', 'Erau2');
        $I->wait(2);
        $I->fillField('#perfilform-email', 'erau@erau.pt');
        $I->wait(2);
        $I->fillField('#perfilform-password', 'password_0');
        $I->wait(2);

        $I->click('Concluído');
        $I->wait(2);
        $I->see('Erau2');
        $I->see('Gestão de Utilizadores');
        $I->wait(10);
    }
}
