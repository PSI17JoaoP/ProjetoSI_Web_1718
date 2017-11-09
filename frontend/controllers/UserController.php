<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{

    public function actionIndex()
    {
        $this->layout = "main-user";

        return $this->render('index');
    }

    public function actionHistory()
    {
        $this->layout = "main-user";

        return $this->render('history');
    }

    public function actionPropostas()
    {
        $this->layout = "main-user";

        return $this->render('propostas');
    }

    public function actionConta()
    {
        $this->layout = "main-user";

        return $this->render('conta');
    }

    public function actionAnuncio()
    {
        $this->layout = "main-user";

        return $this->render('anuncio');
    }
}
