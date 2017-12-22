<?php

namespace api\controllers;

use common\models\Anuncio;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaComputadores;
use common\models\CategoriaEletronica;
use common\models\CategoriaJogos;
use common\models\CategoriaLivros;
use common\models\CategoriaSmartphones;
use common\models\Cliente;
use common\models\User;
use common\models\Proposta;
use frontend\models\GestorCategorias;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;

class AnunciosController extends ActiveController
{
    public $modelClass = 'common\models\Anuncio';

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



    public function actionPropostas($id)
    {
        if($anuncio = Anuncio::findOne(['id' => $id]))
        {
            return ['id' => $id, 'Propostas' => $anuncio->propostas];
        }

        //return ['id' => $id, 'Propostas' => null];
        return new NotFoundHttpException('Não foi encontrado um anuncio com o ID desejado.', 404);
    }

    public function actionTodasPropostas($username)
    {
        $user = User::findOne(['username' => $username]);

        if($user)
        {
            $propostas = Proposta::find()
                    ->join('JOIN', Anuncio::tableName(), Proposta::tableName().'.id_anuncio = '.Anuncio::tableName().'.id')
                    ->where('anuncios.id_user = :user', [':user' => $user->id])
                    ->andWhere('anuncios.estado = :estado', [':estado' => 'ATIVO'])
                    ->all();

            return ['Propostas' => $propostas];
        }

        return new NotFoundHttpException('Não foi encontrado o utilizador', 404);
    }

    public function actionPesquisa($titulo = null, $regiao = null, $categoria = null)
    {
        $params = ['titulo' => $titulo];

        if($regiao !== null)
        {
            $clientesIDs = Cliente::find()->where(['regiao' => $regiao])->select('id_user')->all();

            $params[] = ['id_user' => $clientesIDs];
        }

        if($categoria !== null)
        {
            $categoriasIDs = null;

            switch ($categoria)
            {
                case 'brinquedos':

                    $categoriasIDs = CategoriaBrinquedos::find()->select('id_categoria')->all();

                    break;

                case 'jogos':

                    $categoriasIDs = CategoriaJogos::find()->select('id_categoria')->all();

                    break;

                case 'eletronica':

                    $categoriasIDs = CategoriaEletronica::find()->select('id_categoria')->all();

                    break;

                case 'computadores':

                    $categoriasIDs = CategoriaComputadores::find()->select('id_categoria')->all();

                    break;

                case 'smartphones':

                    $categoriasIDs = CategoriaSmartphones::find()->select('id_categoria')->all();

                    break;

                case 'livros':

                    $categoriasIDs = CategoriaLivros::find()->select('id_categoria')->all();

                    break;

                case 'roupa':

                    $categoriasIDs = CategoriaLivros::find()->select('id_categoria')->all();
            }

            $params[] = ['cat_oferecer' => $categoriasIDs];
        }

        if($anuncios = Anuncio::findAll($params)) {
            return ['Dados' => ['Titulo' => $titulo, 'Região' => $regiao, 'Categoria' => $categoria], 'Anuncios' => $anuncios];
        }

        //return ['Dados' => ['Titulo' => $titulo, 'Região' => $regiao, 'Categoria' => $categoria], 'Anuncios' => null];
        return new NotFoundHttpException('Não foi encontradas categorias com os dados introduzidos.', 404);
    }

    public function actionCategorias($id)
    {
        $gestor = new GestorCategorias();

        if($anuncio = Anuncio::findOne(['id' => $id]))
        {
            if($categorias = $gestor->getCategorias($anuncio, 'cat_oferecer'))
            {
                $categoriaMae = array_shift($categorias);

                return ['id' => $id, 'Categorias' => ['Base' => $categoriaMae, 'Filhas' => $categorias]];
            }
        }

        //return ['id' => $id, 'Categorias' => null];
        return new NotFoundHttpException('Não foi encontradas categorias do anúncio desejado.', 404);
    }
}