<?php

namespace common\tests\unit\models;

use Yii;
use common\models\CategoriaPreferida;
use common\models\User;
use common\fixtures\UserFixture as UserFixture;


/**
 * Categoria test
 */
class CategoriaPreferidaTest extends \Codeception\Test\Unit
{

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    protected function _after()
    {
    }

    public function testCategoriaPreferidaCompleto()
    {
        $idUser = User::findOne(["username" => "bayer.hudson"])->id;


        $categoria = new CategoriaPreferida();
        $categoria->id_user = $idUser;
        $categoria->categoria="brinquedos";
        $categoria->save();
        
        $this->tester->seeRecord('common\models\CategoriaPreferida', ["id_user" => $idUser, "categoria" => "brinquedos"]);


        $cat = CategoriaPreferida::findOne(["id_user" => $idUser, "categoria" => "brinquedos"]);
        
        $cat->categoria = "jogos";
        $cat->save();

        $this->tester->seeRecord('common\models\CategoriaPreferida', ["id_user" => $idUser, "categoria" => "jogos"]);

        CategoriaPreferida::deleteAll("id_user=".$cat->id_user);

        $this->tester->dontSeeRecord('common\models\CategoriaPreferida', ["id_user" => $cat->id_user]);
    }
}