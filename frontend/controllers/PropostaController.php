<?php

namespace frontend\controllers;

use frontend\models\PropostaForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Anuncio;
use common\models\Proposta;

/**
 * PropostaController implements the CRUD actions for Proposta model.
 */
class PropostaController extends Controller
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
     * Displays a single Proposta model.
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
     * Creates a new Proposta model.
     * If creation is successful, the browser will be redirected to the previous page.
     * @param null $id ID do anúncio
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $listaCategorias = array('brinquedos' => "Brinquedos" ,
            'jogos' => "Jogos",
            'eletronica' => "Eletrónica",
            'computadores' => "Computadores",
            'smartphones' => "Smartphones",
            'livros' => "Livros",
            'roupa' => "Roupa");

        $modelForm = new PropostaForm();

        if(Yii::$app->request->get('catProposto') !== null)
        {   
            $cat = Yii::$app->request->get('catProposto');
            $modelForm->catProposto = $cat;

            $modelForm->modelProposto = $modelForm->selecionarCategoria($cat);
        }

        if (Yii::$app->request->post()) {

            if($id !== null /*|| Yii::$app->user->getReturnUrl()*/) {

                $model = new Proposta();

                $anuncioID = Yii::$app->request->post('id_anuncio');

                if (($anuncio = Anuncio::findOne($anuncioID)) !== null) {

                    if ($anuncio->cat_receber !== null) {

                        $model->cat_proposto = $anuncio->cat_receber;
                        $model->quant = $anuncio->quant_receber;
                        $model->id_user = Yii::$app->user->identity->getId();
                        $model->id_anuncio = $anuncio->id;
                        $model->data_proposta = date("Y-m-d h:i:s");
                        $model->estado = 'PENDENTE';
                    }

                    if ($model->save()) {
                        return $this->goBack();
                    } else {

                        if ($anuncio->cat_receber !== null) {
                            $this->goBack();
                        } else {
                            return $this->render('create', [
                                'model' => $model,
                            ]);
                        }
                    }
                }
            } else {
                return $this->goBack();
            }
        } else {
            return $this->render('create', [
                'model' => $modelForm,
                'listaCategorias' => $listaCategorias,
            ]);
        }
    }

    /**
     * Updates an existing Proposta model.
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

    public function actionAceitarRecusar()
    {

        $propostaID = Yii::$app->request->post('id_proposta');
        $model = $this->findModel($propostaID);

        if (Yii::$app->request->post()) {
            
            $propostaEstado = Yii::$app->request->post('estado');

            if ($propostaEstado === 'ACEITE') {
                $model->estado = 'ACEITE';
            }
             
            elseif($propostaEstado === 'RECUSADO') {
                $model->estado = 'RECUSADO';
            }

            if ($model->save()) {
                return $this->goBack();
            }
            else {
                return $this->redirect(['user/propostas']);
            }

        }
    }


    /**
     * Deletes an existing Proposta model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->goBack();
    }

    /**
     * Finds the Proposta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proposta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proposta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
