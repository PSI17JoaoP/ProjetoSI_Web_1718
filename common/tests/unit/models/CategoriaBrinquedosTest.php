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

        $brinquedo = new CategoriaBrinquedos();
        $brinquedo->id_categoria = $categoria->id;
        $brinquedo->editora = "editora";
        $brinquedo->faixa_etaria = 12;
        $brinquedo->descricao = "descricao";
        
        expect("Categoria brinquedo criada", $brinquedo->save())->true();


        $idcat = $this->tester->haveInDatabase('c_brinquedos', [
            "id_categoria" => $brinquedo->id_categoria,
            "editora" => "editora",
            "faixa_etaria" => 12,
            "descricao" => "descricao"
            ]);
        $cat = CategoriaBrinquedos::findOne(['id_categoria' => $idcat]);
        
        $cat->editora = "editora 2";
        $cat->save();

        $this->tester->haveInDatabase('c_brinquedos', [
            "id_categoria" => $cat->id_categoria,
            "editora" => "editora 2",
            "faixa_etaria" => $cat->faixa_etaria,
            "descricao" => $cat->descricao
            ]);


        CategoriaBrinquedos::deleteAll("id_categoria="+$idcat);
        Categoria::deleteAll("id=".$idcat);

        $this->tester->dontSeeInDatabase('categorias', ["id" => $idcat, "nome" => $categoria->nome]);
    }
}