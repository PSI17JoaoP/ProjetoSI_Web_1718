<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\TipoRoupas;
use common\models\CategoriaRoupa;

/**
 * Categoria test
 */
class CategoriaLivrosTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaLivroCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste r";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste r"]);

        $tr = new TipoRoupas();
        $tr->nome = "tr";
        $tr->save();

        $roupa = new CategoriaRoupa();
        $roupa->id_categoria = $categoria->id;
        $roupa->marca = "marca";
        $roupa->tamanho = "tm";
        $roupa->id_tipo = $tr->id;
        $roupa->save();

        $this->tester->seeRecord('common\models\CategoriaRoupa', ["id_categoria" => $roupa->id_categoria]);
        
        $cat = CategoriaRoupa::findOne(['id_categoria' => $roupa->id_categoria]);
        
        $cat->marca = "marca 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaRoupa', ["id_categoria" => $cat->id_categoria, "marca" => "marca 2",]);


        CategoriaRoupa::deleteAll("id_categoria=".$cat->id_categoria);
        Categoria::deleteAll("id=".$cat->id_categoria);

        $this->tester->dontSeeRecord('common\models\Categoria', ["nome" => $categoria->nome]);
    }
}