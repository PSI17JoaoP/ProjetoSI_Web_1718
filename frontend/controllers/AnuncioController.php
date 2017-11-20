<?php

namespace frontend\controllers;

use Yii;
use common\models\Anuncio;
use common\models\AnuncioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\AnuncioForm;

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
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Searches for Anuncio models.
     * @param array $params Os parâmetros de pesquisa
     * @return mixed
     */
    public function actionSearch($params)
    {
        $searchModel = new AnuncioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Anuncio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $listaCategorias = array('brinquedos' => "Brinquedos" , 
                                'jogos' => "Jogos",
                                'eletronica' => "Eletrónica",
                                'computadores' => "Computadores",
                                'smartphones' => "Smartphones",
                                'livros' => "Livros",
                                'roupa' => "Roupa");
        
        $model = new AnuncioForm(); 
        
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


            $data = array(
                '0' => $model->selecionarCategoria($catOferta), 
                '1' => $model->selecionarCategoria($catProcura)
            );


            if (Model::loadMultiple($data, Yii::$app->request->post())) {
                $model->mOferta = $data['0'];
                $model->mProcura = $data['1'];
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
                        'catList' => $listaCategorias,
                    ]);
                }
            }

            else
            {
                return $this->render('create', [
                    'model' => $model,
                    'catList' => $listaCategorias,
                ]);
            }
        }

        else
        {
            return $this->render('create', [
                'model' => $model,
                'catList' => $listaCategorias,
            ]);
        }
    }

    /**
     * Updates an existing Anuncio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Anuncio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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
