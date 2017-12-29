<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\CategoriaLivros;

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
        $categoria->nome="categoria teste l";
        $categoria->save();

        $this->tester->seeRecord('common\models\Categoria', ["nome" => "categoria teste l"]);

        $livro = new CategoriaLivros();
        $livro->id_categoria = $categoria->id;
        $livro->editora = "editora";
        $livro->titulo = "titulo";
        $livro->autor = "autor";
        $livro->isbn = 1123456789;
        $livro->save();

        $this->tester->seeRecord('common\models\CategoriaLivros', ["id_categoria" => $livro->id_categoria]);
        
        $cat = CategoriaLivros::findOne(['id_categoria' => $livro->id_categoria]);
        
        $cat->editora = "editora 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaLivros', ["id_categoria" => $livro->id_categoria, "editora" => "editora 2",]);


        CategoriaLivros::deleteAll("id_categoria=".$cat->id_categoria);
        Categoria::deleteAll("id=".$cat->id_categoria);

        $this->tester->dontSeeRecord('common\models\Categoria', ["nome" => $categoria->nome]);
    }
}