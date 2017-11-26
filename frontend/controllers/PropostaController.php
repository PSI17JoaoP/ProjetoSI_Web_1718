<?php

namespace frontend\controllers;

use common\models\Cliente;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\Anuncio;
use common\models\Proposta;
use frontend\models\PropostaForm;
use frontend\controllers\UserController;

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
                    throw new \Exception('You are not allowed to access this page');
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
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new Proposta model.
     *
     * @param integer $anuncio O ID do Anuncio
     * @return mixed
     */
    public function actionCreate($anuncio)
    {
        $listaCategorias = array('brinquedos' => "Brinquedos" ,
            'jogos' => "Jogos",
            'eletronica' => "Eletrónica",
            'computadores' => "Computadores",
            'smartphones' => "Smartphones",
            'livros' => "Livros",
            'roupa' => "Roupa");

        $modelForm = new PropostaForm();

        //Valicação da escolha da categoria no evento Pjax do _form.php
        if(($categoriaProposto = Yii::$app->request->get('catProposto')) !== null)
        {
            $modelForm->catProposto = $categoriaProposto;
            $modelForm->modelProposto = $modelForm->selecionarCategoria($categoriaProposto);
        }

        if (Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]) === null)
        {
            Yii::$app->runAction('user/cliente', [
                'viewPath' => ['proposta/create'],
                'model' => $modelForm,
            ]);
        }

        if (Yii::$app->request->post()) {

            //Entra neste if, se o anúncio especificar o bem que quer receber.
            //O botão de Enviar Proposta no tipo de anúncios anteriores executa um pedido do tipo POST,
            //no qual envia o id do anúncio (id_anuncio).
            if(($anuncioID = Yii::$app->request->post('id_anuncio'))) {

                $model = new Proposta();

                if (($anuncio = Anuncio::findOne($anuncioID)) !== null) {

                    if ($anuncio->cat_receber !== null) {

                        $model->cat_proposto = $anuncio->cat_receber;
                        $model->quant = $anuncio->quant_receber;
                        $model->id_user = Yii::$app->user->identity->getId();
                        $model->id_anuncio = $anuncio->id;
                        $model->data_proposta = date("Y-m-d h:i:s");
                        $model->estado = 'PENDENTE';

                        if ($model->save()) {
                            return $this->redirect(['user/propostas']);
                        } else {
                            return $this->goBack();
                        }
                    }
                }
            }

            //Caso o pedido POST não contém o id_anuncio, ou seja, o anúncio não especifica o bem a receber,
            //executa o código seguinte.
            else {

                if ($modelForm->load(Yii::$app->request->post()))
                {
                    //Definição de um modelo da categoria escolhida para carregamento de dados.
                    //Implementado de forma a se poder usar os mesmos forms que o AnúncioForm utiliza.
                    $models = array(
                        '0' => $modelForm->selecionarCategoria($categoriaProposto),
                    );

                    if (Model::loadMultiple($models, Yii::$app->request->post()))
                    {
                        $modelForm->modelProposto = $models['0'];

                        //Verificação de dados recebidos, caso tenha sido um pedido AJAX
                        if (Yii::$app->request->isAjax)
                        {
                            Yii::$app->response->format = Response::FORMAT_JSON;
                            return ActiveForm::validate($modelForm);
                        }

                        else if (($categoriaPropostoID = $modelForm->modelProposto->guardar()))
                        {
                            if($modelForm->enviar($categoriaPropostoID))
                            {
                                return $this->redirect(['user/propostas']);
                            } else {
                                return $this->render('create', [
                                    'model' => $modelForm,
                                    'anuncio' => $anuncio,
                                    'listaCategorias' => $listaCategorias,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $modelForm,
            'anuncio' => $anuncio,
            'listaCategorias' => $listaCategorias,
        ]);
    }

    /**
     * Updates an existing Proposta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $propostaID integer O id da proposta
     * @return mixed
     * @internal param int $id
     */
    public function actionUpdate($propostaID)
    {
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
            } else {
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
