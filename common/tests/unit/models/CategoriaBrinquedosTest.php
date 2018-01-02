<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\CategoriaBrinquedos;

/**
 * Categoria test
 */
class CategoriaBrinquedosTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaBrinquedoCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste b";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste b"]);

        $brinquedo = new CategoriaBrinquedos();
        $brinquedo->id_categoria = $categoria->id;
        $brinquedo->editora = "editora";
        $brinquedo->faixa_etaria = 12;
        $brinquedo->descricao = "descricao";
        $brinquedo->save();

        $this->tester->seeRecord('common\models\CategoriaBrinquedos', ["id_categoria" => $brinquedo->id_categoria,]);
        
        $cat = CategoriaBrinquedos::findOne(['id_categoria' => $brinquedo->id_categoria]);
        
        $cat->editora = "editora 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaBrinquedos', ["editora" => "editora 2",]);


        CategoriaBrinquedos::deleteAll("id_categoria=".$cat->id_categoria);
        Categoria::deleteAll("id=".$cat->id_categoria);

        $this->tester->dontSeeRecord('common\models\Categoria', ["nome" => $categoria->nome]);
    }
}