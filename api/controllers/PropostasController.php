<?php

namespace api\controllers;

use common\models\ImagensProposta;
use common\models\Tools;
use common\models\User;
use common\models\Cliente;
use common\models\Proposta;
use Yii;
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
                $categoriaNome = Tools::tipoCategoria($categoriaMae->id);

                return ['id' => $id, 'Categoria' => $categoriaNome, 'Categorias' => ['Base' => $categoriaMae, 'Filhas' => $categorias]];
            }
        }

        throw new NotFoundHttpException('Não foi encontradas categorias da proposta desejada.', 404);

    }

    public function actionImagens($id)
    {
        if($imagens = ImagensProposta::findAll(['proposta_id' => $id])) {

            $imagensBytes = array();

            foreach ($imagens as $imagem) {
                $bytes = file_get_contents(Yii::getAlias('@common/images') . "/" .  $imagem->path_relativo);

                array_push($imagensBytes, base64_encode($bytes));
            }

            if(!empty($imagensBytes)) {
                return ['Imagens' => $imagensBytes];
            }
        }

        throw new NotFoundHttpException('Não foi encontradas imagens da proposta desejada.', 404);
    }
}
