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
     * @var \UnitTester
     */
    protected $tester;


    public function testCategoriaCompleto()
    {
        $categoria = new Categoria();
        $categoria->nome="categoria teste";
        
        expect("Categoria base criada", $categoria->save())->true();

        $idcat = $this->tester->haveInDatabase('categorias', ["nome" => "categoria teste"]);
        $cat = Categoria::findOne(['nome' => "categoria teste"]);
        
        $cat->nome = "categoria teste 2";
        $cat->save();

        $this->tester->haveInDatabase('categorias', ["nome" => "categoria teste 2"]);

        Categoria::deleteAll("nome="+$cat->nome);

        $this->tester->dontSeeInDatabase('categorias', ["id" => $idcat, "nome" => "categoria teste 2"]);
    }
}