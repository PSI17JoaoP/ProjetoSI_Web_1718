<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Categoria;
use common\models\GeneroJogos;
use common\models\CategoriaJogos;
use common\models\CategoriaBrinquedos;

/**
 * Categoria test
 */
class CategoriaJogosTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    public function testCategoriaJogosompleto()
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

        $this->tester->seeRecord('common\models\CategoriaBrinquedos', ["id_categoria" => $brinquedo->id_categoria]);

        $gj = new GeneroJogos();
        $gj->nome = "gj";
        $gj->save();

        $jogo = new CategoriaJogos();
        $jogo->id_brinquedo = $brinquedo->id_categoria;
        $jogo->id_genero = $gj->id;
        $jogo->produtora = "teste";
        $jogo->save();

        $this->tester->seeRecord('common\models\CategoriaJogos', ["id_brinquedo" => $jogo->id_brinquedo]);

        
        $cat = CategoriaJogos::findOne(['id_brinquedo' => $jogo->id_brinquedo]);
        
        $cat->produtora = "produtora 2";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaJogos', ["id_brinquedo" => $jogo->id_brinquedo, "produtora" => "produtora 2",]);


        CategoriaJogos::deleteAll("id_brinquedo=".$cat->id_brinquedo);
        CategoriaBrinquedos::deleteAll("id_categoria=".$cat->id_brinquedo);
        Categoria::deleteAll("id=".$cat->id_brinquedo);

        $this->tester->dontSeeRecord('common\models\Categoria', ["nome" => $categoria->nome]);
    }
}