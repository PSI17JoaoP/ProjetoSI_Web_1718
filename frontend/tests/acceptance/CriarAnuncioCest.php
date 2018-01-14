<?php
namespace frontend\tests;
use common\fixtures\UserFixture;
use frontend\tests\AcceptanceTester;

class CriarAnuncioCest
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

    public function checkCriarAnuncioReceber(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');

        $I->submitForm('#login-form',  [
            'LoginForm[username]' => 'erao',
            'LoginForm[password]' => 'password_0',
        ]);

        $I->wait(5);

        $I->see('Criar Anúncio');
        $I->click('Criar Anúncio');

        $I->wait(3);

        $I->see('Título');
        $I->fillField(['name' => 'AnuncioForm[titulo]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-oferta');
        $I->see('Eletrónica');
        $I->click('Eletrónica');

        $I->wait(3);

        $I->seeElement('EletronicaForm[0][nome]');
        $I->seeElement('EletronicaForm[0][marca]');
        $I->seeElement('EletronicaForm[0][descricao]');

        $I->fillField(['name' => 'AnuncioForm[quantOferta]'], '3');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][nome]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][marca]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][descricao]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-procura');
        $I->see('Livros');
        $I->click('Livros');

        $I->wait(3);

        $I->seeElement('LivrosForm[1][titulo]');
        $I->seeElement('LivrosForm[1][editora]');
        $I->seeElement('LivrosForm[1][autor]');
        $I->seeElement('LivrosForm[1][isbn]');

        $I->fillField(['name' => 'AnuncioForm[quantProcura]'], '2');
        $I->wait(1);
        $I->fillField(['name' => 'LivrosForm[1][titulo]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'LivrosForm[1][editora]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'LivrosForm[1][autor]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'LivrosForm[1][isbn]'], '58546');
        $I->wait(1);

        $I->fillField(['name' => 'AnuncioForm[comentarios]'], 'ComentariosTeste');
        $I->wait(1);

        $I->attachFile(['name' => 'AnuncioForm[imageFiles]'], 'image.jpg');
        $I->wait(5);

        $I->see('Concluido');
        $I->click('Concluido');

        $I->wait(5);

        $I->see('Sucesso! O seu anúncio foi criado com sucesso.');
        $I->see('Título:TesteFuncional');

        $I->seeInCurrentUrl('/user/anuncios');
    }

    /*public function checkCriarAnuncioTodos(FunctionalTester $I)
    {
        $I->amOnPage('site/login');

        $I->submitForm('#login-form',  [
            'LoginForm[username]' => 'erao',
            'LoginForm[password]' => 'password_0',
        ]);

        $I->wait(5);

        $I->see('Criar Anúncio');
        $I->click('Criar Anúncio');

        $I->wait(3);

        $I->see('Título');
        $I->fillField(['name' => 'AnuncioForm[titulo]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-oferta');
        $I->see('Eletrónica');
        $I->click('Eletrónica');

        $I->wait(3);

        $I->seeElement('EletronicaForm[0][nome]');
        $I->seeElement('EletronicaForm[0][marca]');
        $I->seeElement('EletronicaForm[0][descricao]');

        $I->fillField(['name' => 'AnuncioForm[quantOferta]'], '3');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][nome]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][marca]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][descricao]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-procura');
        $I->see('Todos');
        $I->click('Todos');

        $I->wait(3);

        $I->fillField(['name' => 'AnuncioForm[comentarios]'], 'ComentariosTeste');
        $I->wait(1);

        $I->attachFile(['name' => 'AnuncioForm[imageFiles]'], 'image.jpg');
        $I->wait(5);

        $I->see('Concluido');
        $I->click('Concluido');

        $I->wait(5);

        $I->see('Sucesso! O seu anúncio foi criado com sucesso.');
        $I->see('Título:TesteFuncional');

        $I->seeInCurrentUrl('/user/anuncios');
    }*/
}
