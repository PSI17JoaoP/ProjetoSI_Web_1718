<?php

namespace frontend\controllers;

use Yii;
use common\models\Anuncio;
use common\models\AnuncioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\AnuncioForm;
use frontend\models\AnuncioBrinquedosForm;
use frontend\models\AnuncioJogosForm;

use yii\web\Response;


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
    public function actionIndex()
    {
        $searchModel = new AnuncioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Anuncio model.

     * @return mixed
     */
    public function actionView()
    {
        return $this->render('pesquisa');
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
                                'smarthphones' => "Smarthphones",
                                'livros' => "Livros",
                                'roupa' => "Roupa"
                            );
        
        $model = new AnuncioForm(); 
        
        //Validar a escolha da categoria do evento onChange (Oferta)
        if(null !== Yii::$app->request->get('catOferta'))
        {   
            $cat = Yii::$app->request->get('catOferta');
            $model->catOferta = $cat;

            switch ($cat) {
                case 'brinquedos':
                    $model->mOferta = new AnuncioBrinquedosForm();
                    break;
                case 'jogos':
                    $model->mOferta = new AnuncioJogosForm();
                    break;
                case 'eletronica':
                    # code...
                    break;
                case 'computadores':
                    # code...
                    break;
                case 'smarthphones':
                    # code...
                    break;
                case 'livros':
                    # code...
                    break;
                case 'roupa':
                    # code...
                    break;
            }
            
        }

        //Validar a escolha da categoria do evento onChange (Procura)
        if(null !== Yii::$app->request->get('catProcura'))
        {   
            $cat = Yii::$app->request->get('catProcura');
            $model->catProcura = $cat;

            switch ($cat) {
                case 'brinquedos':
                    $model->mProcura = new AnuncioBrinquedosForm();
                    break;
                case 'jogos':
                    $model->mProcura = new AnuncioJogosForm();
                    break;
                case 'eletronica':
                    # code...
                    break;
                case 'computadores':
                    # code...
                    break;
                case 'smarthphones':
                    # code...
                    break;
                case 'livros':
                    # code...
                    break;
                case 'roupa':
                    # code...
                    break;
            }
            
        }

        //Validar envio de dados
        if ($model->load(Yii::$app->request->post())) 
        {
            $catO = $model->catOferta;
            $catP = $model->catProcura;

            switch ($catO) {
                case 'brinquedos':
                    $model->mOferta = new AnuncioBrinquedosForm();
                    break;
                case 'jogos':
                    $model->mOferta = new AnuncioJogosForm();
                    break;
                case 'eletronica':
                    # code...
                    break;
                case 'computadores':
                    # code...
                    break;
                case 'smarthphones':
                    # code...
                    break;
                case 'livros':
                    # code...
                    break;
                case 'roupa':
                    # code...
                    break;
            }

            switch ($catP) {
                case 'brinquedos':
                    $model->mProcura = new AnuncioBrinquedosForm();
                    break;
                case 'jogos':
                    $model->mProcura = new AnuncioJogosForm();
                    break;
                case 'eletronica':
                    # code...
                    break;
                case 'computadores':
                    # code...
                    break;
                case 'smarthphones':
                    # code...
                    break;
                case 'livros':
                    # code...
                    break;
                case 'roupa':
                    # code...
                    break;
            }
            $model->mOferta->load(Yii::$app->request->post());
            $model->mProcura->load(Yii::$app->request->post());
            

            //Validar o pedido AJAX do evento onChange e validar o formulário com os novos dados
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }else if (($modeloO = $model->mOferta->guardar()) && ($modeloP = $model->mProcura->guardar())) 
            {
                if (($modelo = $model->guardar(Yii::$app->user->identity->id, $modeloO, $modeloP))) {
                    return $this->redirect(['view', 'id' => $modelo->id]);
                }else {
                    return $this->render('create', [
                        'model' => $model,
                        'catList' => $listaCategorias,
                    ]);
                }
                
            }else {
                return $this->render('create', [
                    'model' => $model,
                    'catList' => $listaCategorias,
                ]);
            }
        }else 
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
