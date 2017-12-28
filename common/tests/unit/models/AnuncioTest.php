<?php

namespace common\tests\unit\models;

use Yii;
use common\models\User;
use common\models\Anuncio;
use common\models\Cliente;
use common\models\Categoria;
use common\fixtures\UserFixture as UserFixture;

/**
 * Anuncio test
 */
class AnuncioTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    protected $cat1;
    protected $cat2;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);

        $this->cat1 = new Categoria();
        $this->cat1->nome = "cat1";
        $this->cat1->save();

        $this->cat2 = new Categoria();
        $this->cat2->nome = "cat2";
        $this->cat2->save();
/*
        $cliente = new Cliente();
        $cliente->id_user = User::findOne(['username' => 'bayer.hudson'])->id;
        $cliente->nome_completo = "Bayer Hudson";
        $cliente->data_nasc= date('Y-m-d');
        $cliente->telefone=912345678;
        $cliente->regiao="leiria";
        $cliente->save();
*/
    }

    public function testAnuncioCompleto()
    {
        $model = new Anuncio();
        $idUser = User::findOne(['username' => 'bayer.hudson'])->id;

        $model->titulo = 'Anuncio Teste';
        $model->id_user = $idUser;
        $model->cat_oferecer = $this->cat1->id;
        $model->quant_oferecer = 1;
        $model->cat_receber = $this->cat2->id;
        $model->quant_receber = 1;
        $model->estado = "ATIVO";
        $model->data_criacao = \date('Y-m-d h:i:s');
        $model->data_conclusao = null;
        $model->comentarios = "";

        expect('Anuncio é criado', $model->save())->true();

        $idAnuncio = $this->tester->haveInDatabase('anuncios', [
            "titulo" => "Anuncio Teste", 
            "id_user" => $idUser,
            "cat_oferecer" => $this->cat1->id,
            "quant_oferecer" => 1,
            "cat_receber" => $this->cat2->id,
            "estado" => "ATIVO",
            "data_criacao" => $model->data_criacao,
        ]);
        $anuncio = Anuncio::findOne(['id' => $idAnuncio]);

        Anuncio::deleteAll("id="+$idAnuncio);
        $this->tester->dontSeeInDatabase('anuncios', ["id" => $idAnuncio]);
    }

    public function testAnuncioBase()
    {
        $model = new Anuncio();

        $model->titulo = 'Anuncio Teste base';
        $model->id_user = User::findOne(['username' => 'bayer.hudson'])->id;
        $model->cat_oferecer = $this->cat1->id;
        $model->quant_oferecer = 1;
        $model->cat_receber = null;
        $model->quant_receber = null;
        $model->estado = "ATIVO";
        $model->data_criacao = \date('Y-m-d h:i:s');
        $model->data_conclusao = null;
        $model->comentarios = "";

        expect('Anuncio é criado', $model->save())->true();
    }

}