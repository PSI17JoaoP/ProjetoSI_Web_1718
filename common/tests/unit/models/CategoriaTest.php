<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;

/**
 * Categoria test
 */
class CategoriaTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCategoriaCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste";
        
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste"]);


        $cat = Categoria::findOne(['nome' => "categoria teste"]);
        
        $cat->nome = "categoria teste 2";
        $cat->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste 2"]);

        Categoria::deleteAll("id=".$cat->id);

        $this->tester->dontSeeRecord('common\models\Categoria', ["nome" => "categoria teste 2"]);
    }
}