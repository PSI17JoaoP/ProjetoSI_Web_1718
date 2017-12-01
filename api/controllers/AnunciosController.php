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
use frontend\models\GestorCategorias;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class AnunciosController extends ActiveController
{
    public $modelClass = 'common\models\Anuncio';

    public function actionPropostas($id)
    {
        if($anuncio = Anuncio::findOne(['id' => $id]))
        {
            return ['id' => $id, 'Propostas' => $anuncio->propostas];
        }

        //return ['id' => $id, 'Propostas' => null];
        return new NotFoundHttpException('Não foi encontrado um anuncio com o ID desejado.', 404);
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