<?php

namespace api\controllers;

use common\models\Cliente;
use yii\rest\ActiveController;

class ClientesController extends ActiveController
{
    public $modelClass = 'common\models\Cliente';

    public function actionPin($id)
    {
        if(($cliente = Cliente::findOne(['id_user' => $id])))
        {
            if($cliente->pin !== null)
            {
                return ['id_user' => $id, 'PIN' => $cliente->pin];
            }
        }

        //return ['id_user' => $id, 'PIN' => null];
        return null;
    }

    public function actionPreferidas($id)
    {

    }
}
