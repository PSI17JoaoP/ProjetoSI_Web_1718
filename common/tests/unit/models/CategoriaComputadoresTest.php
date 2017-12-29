<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\CategoriaEletronica;
use common\models\CategoriaComputadores;

/**
 * Categoria test
 */
class CategoriaComputadoresTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaComputadoresCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste c";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste c"]);

        $eletro = new CategoriaEletronica();
        $eletro->id_categoria = $categoria->id;
        $eletro->descricao = "teste";
        $eletro->marca = "teste";
        $eletro->save();

        $this->tester->seeRecord('common\models\CategoriaEletronica', ["id_categoria" => $eletro->id_categoria]);


        $pc = new CategoriaComputadores();
        $pc->id_eletronica = $eletro->id_categoria;
        $pc->processador = "teste";
        $pc->ram = "test";
        $pc->hdd = "teste";
        $pc->gpu = "teste";
        $pc->os = "teste";
        $pc->portatil = 0;
        $pc->save();
        
        $this->tester->seeRecord('common\models\CategoriaComputadores', ["id_eletronica" => $pc->id_eletronica]);

        $cat = CategoriaComputadores::findOne(['id_eletronica' => $pc->id_eletronica]);
        
        $cat->processador = "teste 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaComputadores', ["id_eletronica" => $pc->id_eletronica, "processador" => "teste 2"]);

        CategoriaComputadores::deleteAll("id_eletronica=".$cat->id_eletronica);
        CategoriaEletronica::deleteAll("id_categoria=".$cat->id_eletronica);
        Categoria::deleteAll("id=".$cat->id_eletronica);

        $this->tester->dontSeeRecord('common\models\Categoria', ["id" => $cat->id_eletronica]);
    }
}