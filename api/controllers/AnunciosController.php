<?php

namespace api\controllers;

use yii\db\Query;
use common\models\User;
use common\models\Tools;
use common\models\Anuncio;
use common\models\Cliente;
use common\models\Proposta;
use yii\rest\ActiveController;
use common\models\CategoriaRoupa;
use common\models\CategoriaJogos;
use common\models\ImagensAnuncio;
use common\models\CategoriaLivros;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;
use frontend\models\GestorCategorias;
use common\models\CategoriaPreferida;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaEletronica;
use common\models\CategoriaSmartphones;
use common\models\CategoriaComputadores;

class AnunciosController extends ActiveController
{
    public $modelClass = 'common\models\Anuncio';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['pesquisa'],
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
        throw new NotFoundHttpException('Não foi encontrado um anuncio com o ID desejado.', 404);
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

        throw new NotFoundHttpException('Não foi encontrado o utilizador', 404);
    }

    public function actionPesquisa($titulo = null, $regiao = null, $categoria = null)
    {
        $params1 = "";
        $params2 = "";
        $params3 = "";

        if($titulo !== null)
        {
            $params1 = ['like', 'titulo', $titulo];
        }

        if($regiao !== null)
        {
            $clientesIDs = Cliente::find()->where(['regiao' => $regiao])->select('id_user')->all();

            $params2 = ['id_user' => $clientesIDs];
        }

        if($categoria !== null)
        {
            $categoriasIDs = null;
            $keyCat = null;

            switch ($categoria)
            {
                case 'brinquedos':

                    $categoriasIDs = CategoriaBrinquedos::find()->select('id_categoria')->all();
                    $keyCat = 'id_categoria';
                    break;

                case 'jogos':

                    $categoriasIDs = CategoriaJogos::find()->select('id_brinquedo')->all();
                    $keyCat = 'id_brinquedo';
                    break;

                case 'eletronica':

                    $categoriasIDs = CategoriaEletronica::find()->select('id_categoria')->all();
                    $keyCat = 'id_categoria';
                    break;

                case 'computadores':

                    $categoriasIDs = CategoriaComputadores::find()->select('id_eletronica')->all();
                    $keyCat = 'id_eletronica';
                    break;

                case 'smartphones':

                    $categoriasIDs = CategoriaSmartphones::find()->select('id_eletronica')->all();
                    $keyCat = 'id_eletronica';
                    break;

                case 'livros':

                    $categoriasIDs = CategoriaLivros::find()->select('id_categoria')->all();
                    $keyCat = 'id_categoria';
                    break;

                case 'roupa':

                    $categoriasIDs = CategoriaLivros::find()->select('id_categoria')->all();
                    $keyCat = 'id_categoria';
            }
            $listaIDs = [];
            
            foreach ($categoriasIDs as $key => $cat) {
                array_push($listaIDs, $cat[$keyCat]);
            }

            $params3 = ['cat_oferecer' => $listaIDs];
        }

        if($anuncios = Anuncio::find()->where($params1)->andWhere($params2)->andWhere($params3)->all()) {
            return ['Dados' => ['Titulo' => $titulo, 'Região' => $regiao, 'Categoria' => $categoria], 'Anuncios' => $anuncios];
        }

        //return ['Dados' => ['Titulo' => $titulo, 'Região' => $regiao, 'Categoria' => $categoria], 'Anuncios' => null];
        throw new NotFoundHttpException('Não foi encontradas categorias com os dados introduzidos.', 404);
    }

    public function actionCategorias($id)
    {
        $gestor = new GestorCategorias();

        if($anuncio = Anuncio::findOne(['id' => $id]))
        {
            if($categorias = $gestor->getCategorias($anuncio, 'cat_oferecer'))
            {
                $categoriaMae = array_shift($categorias);
                $cat = Tools::tipoCategoria($categoriaMae->id);

                return ['id' => $id, 'Flag' => $cat, 'Categorias' => ['Base' => $categoriaMae, 'Filhas' => $categorias]];
            }
        }

        //return ['id' => $id, 'Categorias' => null];
        throw new NotFoundHttpException('Não foi encontradas categorias do anúncio desejado.', 404);
    }

    public function actionSugeridos($username)
    {
        $user = User::findOne(['username' => $username]);

        if($user)
        {
            $catPreferidas = CategoriaPreferida::find()
                ->select('categoria')
                ->where('id_user = :id_user', [':id_user' => $user->id])
                ->asArray()
                ->all();


            $anunciosNotUser = (new Query())
                ->select(['anuncios.*'])
                ->from(Anuncio::tableName())
                ->where('id_user != :id_user', [':id_user' => $user->id])
                ->andWhere('estado != :estado', [':estado' => "CONCLUIDO"])
                ->join('JOIN', ImagensAnuncio::tableName(), Anuncio::tableName().'.id = '.ImagensAnuncio::tableName().'.anuncio_id')
                ->addSelect(ImagensAnuncio::tableName().'.path_relativo');
                
            $anunciosDestaques = (new Query())
                ->from(['table' => $anunciosNotUser]);

            foreach ($catPreferidas as $key => $value) 
            {
                $stupidList = (new Query());
                $goodList = array();

                switch ($value['categoria']) 
                {
                    case 'brinquedos':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaBrinquedos::tableName())->all();
                        break;
                    case 'jogos':
                        $stupidList = $stupidList->select('id_brinquedo')->from(CategoriaJogos::tableName())->all();
                        break;
                    case 'eletronica':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaEletronica::tableName())->all();
                        break;
                    case 'computadores':
                        $stupidList = $stupidList->select('id_eletronica')->from(CategoriaComputadores::tableName())->all();                    
                        break;
                    case 'smartphones':
                        $stupidList = $stupidList->select('id_eletronica')->from(CategoriaSmartphones::tableName())->all();                    
                        break;
                    case 'livros':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaLivros::tableName())->all();
                        break;
                    case 'roupa':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaRoupa::tableName())->all();
                }

                
                foreach ($stupidList as $key => $value) {
                    \array_push($goodList,  $value[\key($value)]);
                    
                }

                $anunciosDestaques = $anunciosDestaques->orWhere(['IN', 'cat_oferecer', $goodList]);
            }

        
            $anunciosDestaques = $anunciosDestaques->orderBy('table.id DESC')->distinct()->limit(5)->all();

            return $anunciosDestaques;
        }

        throw new NotFoundHttpException('Utilizador não encontrado.', 404);
    }

}