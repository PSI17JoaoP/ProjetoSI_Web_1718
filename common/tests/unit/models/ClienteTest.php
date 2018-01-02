<?php

namespace common\tests\unit\models;

use Yii;
use common\models\CLiente;
use common\models\User;
use common\fixtures\UserFixture as UserFixture;


/**
 * Categoria test
 */
class ClienteTest extends \Codeception\Test\Unit
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

    public function testClienteCompleto()
    {
        $idUser = User::findOne(["username" => "bayer.hudson"])->id;

        Cliente::deleteAll("id_user=".$idUser);

        $cliente = new Cliente();
        $cliente->id_user = $idUser;
        $cliente->nome_completo="bayer hudson hudson";
        $cliente->data_nasc = date('Y-m-d');
        $cliente->telefone = 914785236;
        $cliente->regiao = "leiria";
        $cliente->save();
        
        $this->tester->seeRecord('common\models\Cliente', ["nome_completo" => "bayer hudson hudson"]);

        $cli = Cliente::findOne(["nome_completo" => "bayer hudson hudson"]);
        
        $cli->regiao = "lisboa";
        $cli->save();

        $this->tester->seeRecord('common\models\Cliente', ["nome_completo" => "bayer hudson hudson", "regiao" => "lisboa"]);

        Cliente::deleteAll("id_user=".$cli->id_user);

        $this->tester->dontSeeRecord('common\models\Cliente', ["id_user" => $idUser]);
    }
}