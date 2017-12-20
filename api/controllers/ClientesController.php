<?php

namespace api\controllers;

use common\models\Cliente;
use common\models\User;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class ClientesController extends ActiveController
{
    public $modelClass = 'common\models\Cliente';

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

    public function actionPin($pin)
    {
        if(($cliente = Cliente::findOne(['pin' => $pin])))
        {
            $user = User::findOne(['id' => $cliente->id_user]);

            return ['PIN' => $pin, 'User' => ['Username' => $user->username, 'Email' => $user->email]];
        }

        //return ['PIN' => null, 'User' => null];
        return new NotFoundHttpException('Não foi encontrado o utilizador desejado.', 404);
    }

    public function actionPreferidas($id)
    {

    }
}
