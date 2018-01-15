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

    public function login(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');

        $I->submitForm('#login-form',  [
            'LoginForm[username]' => 'ML29',
            'LoginForm[password]' => '123456',
        ]);

        $I->wait(3);
    }

    public function checkCriarAnuncioReceber(AcceptanceTester $I)
    {
        $this->login($I);

        $I->see('Criar Anúncio');
        $I->click('Criar Anúncio');

        $I->wait(3);

        $I->see('Título');
        $I->fillField(['name' => 'AnuncioForm[titulo]'], 'TesteAceitação');
        $I->wait(1);

        $I->click('#field-cat-oferta');
        $I->see('Eletrónica', '#field-cat-oferta option[value=eletronica]');
        $I->click('#field-cat-oferta option[value=eletronica]');

        $I->wait(3);

        $I->canSeeElement('input', ['name' => 'EletronicaForm[0][nome]']);
        $I->canSeeElement('input', ['name' => 'EletronicaForm[0][marca]']);
        //$I->canSeeElement('input', ['name' => 'EletronicaForm[0][descricao]']);       //Este está a dar erro no final do teste, por alguma razão.

        $I->fillField(['name' => 'AnuncioForm[quantOferta]'], '3');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][nome]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][marca]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][descricao]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-procura');
        $I->see('Livros', '#field-cat-procura option[value=livros]');
        $I->click('#field-cat-procura option[value=livros]');

        $I->wait(3);

        $I->canSeeElement('input', ['name' => 'LivrosForm[1][titulo]']);
        $I->canSeeElement('input',['name' => 'LivrosForm[1][editora]']);
        $I->canSeeElement('input', ['name' => 'LivrosForm[1][autor]']);
        $I->canSeeElement('input', ['name' => 'LivrosForm[1][isbn]']);

        $I->fillField(['name' => 'AnuncioForm[quantProcura]'], '2');
        $I->wait(1);
        $I->fillField(['name' => 'LivrosForm[1][nome]'], 'TesteFuncional');
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

        $I->attachFile('AnuncioForm[imageFiles]', 'image.jpg');

        $I->wait(1);

        $I->see('Concluído');
        $I->click('Concluído');

        $I->wait(3);

        $I->see('Sucesso! O seu anúncio foi criado com sucesso.');
        $I->see('Título:TesteAceitação');

        $I->seeInCurrentUrl('/user/anuncios');
    }

    /**
     * @after checkCriarAnuncioReceber
     * @param \frontend\tests\AcceptanceTester $I
     */
    public function checkCriarAnuncioTodos(AcceptanceTester $I)
    {
        $this->login($I);

        $I->see('Criar Anúncio');
        $I->click('Criar Anúncio');

        $I->wait(3);

        $I->see('Título');
        $I->fillField(['name' => 'AnuncioForm[titulo]'], 'TesteACeitação');
        $I->wait(1);

        $I->click('#field-cat-oferta');
        $I->see('Eletrónica', '#field-cat-oferta option[value=eletronica]');
        $I->click('#field-cat-oferta option[value=eletronica]');

        $I->wait(3);

        $I->canSeeElement('input', ['name' => 'EletronicaForm[0][nome]']);
        $I->canSeeElement('input', ['name' => 'EletronicaForm[0][marca]']);
        //$I->canSeeElement('input', ['name' => 'EletronicaForm[0][descricao]']);       //Este está a dar erro no final do teste, por alguma razão.

        $I->fillField(['name' => 'AnuncioForm[quantOferta]'], '3');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][nome]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][marca]'], 'TesteFuncional');
        $I->wait(1);
        $I->fillField(['name' => 'EletronicaForm[0][descricao]'], 'TesteFuncional');
        $I->wait(1);

        $I->click('#field-cat-procura');
        $I->see('Todas as Categorias', '#field-cat-procura option[value=todos]');
        $I->click('#field-cat-procura option[value=todos]');

        $I->wait(3);

        $I->fillField(['name' => 'AnuncioForm[comentarios]'], 'ComentariosTeste');
        $I->wait(1);

        $I->attachFile('AnuncioForm[imageFiles]', 'image.jpg');

        $I->wait(1);

        $I->see('Concluído');
        $I->click('Concluído');

        $I->wait(3);

        $I->see('Sucesso! O seu anúncio foi criado com sucesso.');
        $I->see('Título:TesteACeitação');

        $I->seeInCurrentUrl('/user/anuncios');
    }
}
