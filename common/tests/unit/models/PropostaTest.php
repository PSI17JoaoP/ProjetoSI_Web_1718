<?php
namespace common\tests\unit\models;


use common\fixtures\UserFixture;
use common\models\Anuncio;
use common\models\Categoria;
use common\models\Proposta;
use common\models\User;

class PropostaTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    protected function _after()
    {
    }

    public function testPropostaCompleto()
    {
        $data = date('Y-m-d');

        $userID = User::findOne(['username' => 'bayer.hudson'])->id;

        $categoriaOferecerID = $this->tester->haveRecord('common\models\Categoria', [
            'nome' => 'UnitTestCategoriaOferecer'
        ]);

        $anuncioID = $this->tester->haveRecord('common\models\Anuncio', [
            'titulo' => 'UnitTestAnuncioProposta',
            'id_user' => $userID,
            'cat_oferecer' => $categoriaOferecerID,
            'quant_oferecer' => 3,
            'estado' => 'ATIVO',
            'data_criacao' => $data,
            'comentarios' => 'Unit'
        ]);

        $categoriaPropostoID = $this->tester->haveRecord('common\models\Categoria', [
            'nome' => 'UnitTestCategoriaProposto'
        ]);

        $proposta = new Proposta();
        $proposta->id_user = $userID;
        $proposta->id_anuncio = $anuncioID;
        $proposta->cat_proposto = $categoriaPropostoID;
        $proposta->quant = 2;
        $proposta->estado = 'PENDENTE';
        $proposta->data_proposta = $data;

        $this->assertTrue($proposta->save());

        $this->tester->seeRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'PENDENTE',
            'data_proposta' => $data,
        ]);

        $propostaCriada = $this->tester->grabRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'PENDENTE',
            'data_proposta' => $data,
        ]);

        $propostaCriada->estado = 'ACEITE';

        $this->assertEquals('ACEITE', $propostaCriada->estado);

        $this->assertFalse($propostaCriada->isNewRecord);

        $this->assertTrue($propostaCriada->save());

        $this->tester->seeRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'ACEITE',
            'data_proposta' => $data,
        ]);

        $this->tester->dontSeeRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'PENDENTE',
            'data_proposta' => $data,
        ]);

        $propostaAlterada = $this->tester->grabRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'ACEITE',
            'data_proposta' => $data,
        ]);

        $this->assertNotFalse($propostaAlterada->delete());

        $this->tester->dontSeeRecord('common\models\Proposta', [
            'id_user' => $userID,
            'id_anuncio' => $anuncioID,
            'cat_proposto' => $categoriaPropostoID,
            'quant' => 2,
            'estado' => 'ACEITE',
            'data_proposta' => $data,
        ]);
    }
}