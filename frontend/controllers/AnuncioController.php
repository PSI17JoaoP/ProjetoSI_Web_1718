<?php

namespace frontend\controllers;

class AnuncioController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCriar()
    {
        return $this->render('criar');
    }

}
