<?php

namespace api\controllers;

use common\models\User;
use common\models\Cliente;
use common\models\Proposta;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use frontend\models\GestorCategorias;
use yii\web\NotFoundHttpException;


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

    public function actionCategorias($id)
    {
        $gestor = new GestorCategorias();

        if($proposta = Proposta::findOne(['id' => $id]))
        {
            if($categorias = $gestor->getCategorias($proposta, 'cat_proposto'))
            {
                $categoriaMae = array_shift($categorias);

                return ['id' => $id, 'Categorias' => ['Base' => $categoriaMae, 'Filhas' => $categorias]];
            }
        }

        throw new NotFoundHttpException('Não foi encontradas categorias da proposta desejada.', 404);

    }
}
