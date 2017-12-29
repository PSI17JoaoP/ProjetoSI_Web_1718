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
     * @var \UnitTester
     */
    protected $tester;


    public function testCategoriaCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste";
        $categoria->save();

        $eletro = new CategoriaEletronica();
        $eletro->id_categoria = $categoria->id;
        $eletro->descricao = "teste";
        $eletro->marca = "teste";
        $eletro->save();

        $pc = new CategoriaComputadores();
        $pc->id_eletronica = $eletro->id_categoria;
        $pc->processador = "teste";
        $pc->ram = "teste";
        $pc->hdd = "teste";
        $pc->gpu = "teste";
        $pc->os = "teste";
        $pc->portatil = 0;
        
        expect("Categoria computador criada", $pc->save())->true();

        $pc->save();
        
        $this->tester->seeInDatabase('c_computadores', ['id_eletronica' => $pc->id_eletronica,]);
        $cat = CategoriaComputadores::findOne(['id_eletronica' => $pc->id_eletronica]);
        
        $cat->processador = "teste 2";
        $cat->save();

        
        //$this->tester->seeInDatabase('c_computadores', ["id_eletronica" => $pc->id_eletronica]);


        CategoriaComputadores::deleteAll("id_eletronica=".$cat->id);
        CategoriaEletronica::deleteAll("id_categoria=".$cat->id);
        Categoria::deleteAll("id=".$cat->id);

        $this->tester->dontSeeInDatabase('categorias', ["id" => $idcat, "nome" => "categoria teste"]);
    }
}