<?php

namespace api\controllers;

use yii\rest\ActiveController;
use common\models\Cliente;
use common\models\User;

class PropostasController extends ActiveController
{
    public $modelClass = 'common\models\Proposta';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];

        return $behaviors;
    }

    public function auth($pin)
    {
    
        $cliente = User::find()
                ->join('JOIN', Cliente::tableName(), User::tableName().'.id = '.Cliente::tableName().'.id_user')
                ->where(['pin' => $pin])
                ->one();

        return $cliente;
    }

    public function actionCategorias()
    {

    }
}
