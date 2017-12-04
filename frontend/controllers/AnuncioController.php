<?php

namespace frontend\controllers;

use Yii;

use yii\base\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\AnuncioForm;
use common\models\Anuncio;
use common\models\Cliente;
use common\models\Tools;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaComputadores;
use common\models\CategoriaEletronica;
use common\models\CategoriaJogos;
use common\models\CategoriaLivros;
use common\models\CategoriaRoupa;
use common\models\CategoriaSmartphones;

use yii\base\Model;

/**
 * AnuncioController implements the CRUD actions for Anuncio model.
 */
class AnuncioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'search'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['search'],
                        'allow' => true,
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new Exception('You are not allowed to access this page');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Anuncio models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new AnuncioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Anuncio model.
     * @param integer $id
     * @return mixed
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Searches for Anuncio models.
     * @param string $titulo
     * @param string $categoria
     * @param string $regiao
     * @return mixed
     */
    public function actionSearch($titulo = null, $categoria = null, $regiao = null)
    {
        $anuncios = (new Query())
            ->from(Anuncio::tableName());

        //Filtrar categoria
        switch ($categoria)
        {
            case 'brinquedos':
                $anuncios = $anuncios->join('JOIN', CategoriaBrinquedos::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaBrinquedos::tableName().".id_categoria");
                break;
            case 'jogos':
                $anuncios = $anuncios->join('JOIN', CategoriaJogos::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaJogos::tableName().".id_brinquedo");
                break;
            case 'eletronica':
                $anuncios = $anuncios->join('JOIN', CategoriaEletronica::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaEletronica::tableName().".id_categoria");
                break;
            case 'computadores':
                $anuncios = $anuncios->join('JOIN', CategoriaComputadores::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaComputadores::tableName().".id_eletronica");
                break;
            case 'smartphones':
                $anuncios = $anuncios->join('JOIN', CategoriaSmartphones::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaSmartphones::tableName().".id_eletronica");
                break;
            case 'livros':
                $anuncios = $anuncios->join('JOIN', CategoriaLivros::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaLivros::tableName().".id_categoria");
                break;
            case 'roupa':
                $anuncios = $anuncios->join('JOIN', CategoriaRoupa::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaRoupa::tableName().".id_categoria");
        }

        //Filtrar região
        if(in_array($regiao, Tools::listaRegioes()))
        {
            $anuncios = $anuncios->join('JOIN', Cliente::tableName(), Anuncio::tableName().".id_user = ". Cliente::tableName().".id_user");
            $anuncios = $anuncios->where('regiao=:regiao', [':regiao' => $regiao]);

            if ($titulo != null) 
            {    
                $anuncios = $anuncios->andWhere(['like', 'titulo', $titulo]);
            }
        }

        //Filtrar título
        else if ($titulo != null)
        {            
            $anuncios = $anuncios->Where(['like', 'titulo', $titulo]);
        }

        $anuncios = $anuncios->all();

        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $anuncios;
        }

        else
        {
            return $this->render('pesquisa', [
                'anuncios' => $anuncios,
                'regioes' => Tools::listaRegioes(),
                'categorias' => Tools::listaCategorias()
            ]);
        }
    }

    /**
     * Creates a new Anuncio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnuncioForm();

        //Validar estado de conta do cliente. SE for o seu 1º anúncio, mostrar popup de informações extra
        if (Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]) === null)
        {
            Yii::$app->runAction('user/cliente', [
                'viewPath' => 'anuncio/create',
                'model' => $model,
            ]);
        }
        
        //Validar a escolha da categoria do evento onChange (Oferta)
        if(Yii::$app->request->get('catOferta') !== 'null')
        {   
            $cat = Yii::$app->request->get('catOferta');
            $model->catOferta = $cat;

            $model->mOferta = $model->selecionarCategoria($cat);
        }

        //Validar a escolha da categoria do evento onChange (Procura)
        if(Yii::$app->request->get('catProcura') !== 'null')
        {   
            $cat = Yii::$app->request->get('catProcura');
            $model->catProcura = $cat;

            $model->mProcura = $model->selecionarCategoria($cat);
        }
    
        //Validar envio de dados
        if ($model->load(Yii::$app->request->post())) 
        {
            $catOferta = $model->catOferta;
            $catProcura = $model->catProcura;

            $model->mOferta = $model->selecionarCategoria($catOferta);
            $model->mProcura = $model->selecionarCategoria($catProcura);

            if ($catOferta === $catProcura) {

                $data = array(
                    '0' => $model->selecionarCategoria($catOferta), 
                    '1' => $model->selecionarCategoria($catProcura)
                );

                if (Model::loadMultiple($data, Yii::$app->request->post())) {
                    $model->mOferta = $data['0'];
                    $model->mProcura = $data['1'];
                }
            }

            else
            {
                //Oferta
                $dataO = array(
                    '0' => $model->selecionarCategoria($catOferta)
                );

                if (Model::loadMultiple($dataO, Yii::$app->request->post())) {
                    $model->mOferta = $dataO['0'];
                }

                //Procura
                if($catProcura !== 'todos') {

                    $dataP = array(
                        '1' => $model->selecionarCategoria($catProcura)
                    );

                    if(Model::loadMultiple($dataP, Yii::$app->request->post())) {
                        $model->mProcura = $dataP['1'];
                    }
                }
            }

            //Validar o pedido AJAX do evento onChange e validar o formulário com os novos dados
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            else if (($modeloOferta = $model->mOferta->guardar()) && ($modeloProcura = $model->mProcura->guardar()))
            {
                if (($modelo = $model->guardar(Yii::$app->user->identity->getId(), $modeloOferta, $modeloProcura))) {
                    return $this->redirect(['user/anuncios', 'model' => $modelo]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'catList' => Tools::listaCategorias(),
                    ]);
                }
            }

            else
            {
                return $this->render('create', [
                    'model' => $model,
                    'catList' => Tools::listaCategorias(),
                ]);
            }
        }

        else
        {
            return $this->render('create', [
                'model' => $model,
                'catList' => Tools::listaCategorias(),
            ]);
        }
    }

    /**
     * Updates an existing Anuncio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing Anuncio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Anuncio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anuncio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anuncio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
