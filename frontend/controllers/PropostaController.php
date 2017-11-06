<?php

namespace app\controllers;

class PropostaController extends \yii\web\Controller
{
    public function actionAccept()
    {
        return $this->render('accept');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReject()
    {
        return $this->render('reject');
    }

}
