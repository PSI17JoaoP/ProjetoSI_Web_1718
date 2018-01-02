<?php

namespace api\controllers;

use common\models\User;
use common\models\Cliente;
use common\models\Anuncio;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;


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

            return ['PIN' => $pin, 'User' => ['ID' => $user->id, 'Username' => $user->username, 'Email' => $user->email]];
        }

        //return ['PIN' => null, 'User' => null];
        throw new NotFoundHttpException('Não foi encontrado o utilizador desejado.', 404);
    }

    public function actionPreferidas($id)
    {
        if($user = User::findOne(['id' => $id]))
        {
            $preferidas = [];

            foreach ($user->categoriasPreferidas as $key => $value) {
                \array_push($preferidas, $value->categoria);
            }

            return ['ID_User' => $id, 'CategoriasPreferidas' => $preferidas];
        }

        throw new NotFoundHttpException('Não foi encontrado o utilizador desejado.', 404);
    }

    public function actionAnuncios($id)
    {
        if($cliente = Cliente::findOne(['id_user' => $id]))
        {
            $anuncios = Anuncio::findAll(['id_user' => $id]);

            return ['ID_User' => $id, 'Anuncios' => $anuncios];
        }

        throw new NotFoundHttpException('Não foi encontrado o utilizador desejado.', 404);
    }
}
