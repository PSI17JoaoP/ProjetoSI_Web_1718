<?php

namespace frontend\controllers;

use Yii;
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
     * @param integer $anuncioId O id do anúncio
     * @return mixed
     */
    public function actionCreate($anuncioId)
    {
        $model = new Proposta();

        if ($model->load(Yii::$app->request->post())) {

            if (($anuncio = Anuncio::findOne($anuncioId)) !== null) {

                if($anuncio->cat_receber !== null) {
                    $model->cat_proposto = $anuncio->cat_receber;
                    $model->quant = $anuncio->quant_receber;
                    $model->id_user = Yii::$app->user->identity->getId();
                    $model->id_anuncio = $anuncio->id;
                }

                if($model->save()) {
                    return $this->goBack();
                }

                else {

                    if($anuncio->cat_receber !== null) {
                        $this->goBack();
                    }

                    else {
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
            }

            else {
                return $this->goBack();
            }
        }

        else {
            return $this->render('create', [
                'model' => $model,
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
