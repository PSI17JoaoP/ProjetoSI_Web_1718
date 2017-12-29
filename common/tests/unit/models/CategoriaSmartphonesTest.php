<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\CategoriaEletronica;
use common\models\CategoriaSmartphones;

/**
 * Categoria test
 */
class CategoriaSmartphonesTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaComputadoresCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste s";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste s"]);

        $eletro = new CategoriaEletronica();
        $eletro->id_categoria = $categoria->id;
        $eletro->descricao = "teste";
        $eletro->marca = "teste";
        $eletro->save();

        $this->tester->seeRecord('common\models\CategoriaEletronica', ["id_categoria" => $eletro->id_categoria]);


        $sm = new CategoriaSmartphones();
        $sm->id_eletronica = $eletro->id_categoria;
        $sm->processador = "teste";
        $sm->ram = "test";
        $sm->hdd = "teste";
        $sm->os = "teste";
        $sm->tamanho = "teste";
        $sm->save();
        
        $this->tester->seeRecord('common\models\CategoriaSmartphones', ["id_eletronica" => $sm->id_eletronica]);

        $cat = CategoriaSmartphones::findOne(['id_eletronica' => $sm->id_eletronica]);
        
        $cat->processador = "teste 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaSmartphones', ["id_eletronica" => $cat->id_eletronica, "processador" => "teste 2"]);

        CategoriaSmartphones::deleteAll("id_eletronica=".$cat->id_eletronica);
        CategoriaEletronica::deleteAll("id_categoria=".$cat->id_eletronica);
        Categoria::deleteAll("id=".$cat->id_eletronica);

        $this->tester->dontSeeRecord('common\models\Categoria', ["id" => $cat->id_eletronica]);
    }
}