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

    public function actionImagensMovel($id)
    {
        $imagensMovel = array();

        $imagensBase64 = Yii::$app->request->post('Imagens');

        $proposta = Proposta::findOne(['id' => $id]);

        if($imagensBase64 != null && $proposta != null) {

            foreach ($imagensBase64 as $key => $imagemBase64) {

                $imagemBytes = base64_decode($imagemBase64);

                if ($imagemBytes != false) {

                    $nomeImagem = $id . '_' . $key . '.png';

                    $imagemAnuncio = new ImagensProposta();
                    $imagemAnuncio->proposta_id = $id;
                    $imagemAnuncio->path_relativo = $nomeImagem;

                    if ($imagemAnuncio->save()) {

                        $bytesImagem = file_put_contents(Yii::getAlias('@common/images') . "/" . $proposta->idAnuncio->id . '_' . $nomeImagem, $imagemBytes);

                        if ($bytesImagem != false) {
                            array_push($imagensMovel, [$proposta->idAnuncio->id . '_' . $nomeImagem => $imagemBase64]);
                        } else {
                            throw new ServerErrorHttpException('Ocorreu um erro ao guardar as imagens da aplicação móvel.' . $bytesImagem . '_' . count($imagemBytes));
                        }

                    } else {
                        throw new ServerErrorHttpException('Não foi possivél guardar as imagens devido um erro no processamento.');
                    }

                } else {
                    throw new ServerErrorHttpException('Ocorreu um erro no processamento das imagens da aplicação móvel.');
                }
            }

            if (!empty($imagensMovel)) {
                return $imagensMovel;
            }
        }

        throw new ServerErrorHttpException('Ocorreu um erro no envio das imagens da aplicação móvel.');
    }
}
