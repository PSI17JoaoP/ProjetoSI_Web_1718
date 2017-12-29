<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\CategoriaEletronica;

/**
 * Categoria test
 */
class CategoriaEletronicaTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaComputadoresCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste e";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste e"]);

        $eletro = new CategoriaEletronica();
        $eletro->id_categoria = $categoria->id;
        $eletro->descricao = "teste";
        $eletro->marca = "teste";
        $eletro->save();

        $this->tester->seeRecord('common\models\CategoriaEletronica', ["id_categoria" => $eletro->id_categoria]);

        $cat = CategoriaEletronica::findOne(['id_categoria' => $eletro->id_categoria]);
        
        $cat->marca = "teste 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaEletronica', ["id_categoria" => $eletro->id_categoria, "marca" => "teste 2"]);

        CategoriaEletronica::deleteAll("id_categoria=".$cat->id_categoria);
        Categoria::deleteAll("id=".$cat->id_categoria);

        $this->tester->dontSeeRecord('common\models\Categoria', ["id" => $cat->id_categoria]);
    }
}