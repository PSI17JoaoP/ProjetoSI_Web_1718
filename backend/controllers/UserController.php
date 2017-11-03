<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{
   
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'perfil'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $notifications = array('Notification 1', 'Notification 2');
        
        $this->view->params['notifications'] = $notifications;
        $this->layout = 'main';

        return $this->render('index');
    }

    public function actionPerfil()
    {

        $notifications = array('Notification 1', 'Notification 2');
        
        $this->view->params['notifications'] = $notifications;
        $this->layout = 'main';

        //Fazer Modelo para edição de dados no perfil
        //  Basear-me no signupForm
        

        return $this->render('perfil');
        /*
        return $this->render('login', [
                'model' => $model,
            ]);
        */
    }
}