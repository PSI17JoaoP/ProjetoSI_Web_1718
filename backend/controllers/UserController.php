<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\PerfilForm;

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

        
        $model = new PerfilForm();

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            
            return $this->render('index');
            
        } else {

            return $this->render('perfil', [
                'model' => $model,
            ]);
        }
    }
}