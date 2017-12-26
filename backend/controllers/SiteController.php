<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use common\models\User;
use common\models\Cliente;
use common\models\Anuncio;
use common\models\Proposta;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
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
        
        $estatisticas = [];

        $nAnuncios = (new Query())
                ->from(Anuncio::tableName())
                ->where('estado = :estado', [':estado' => 'ATIVO'])
                ->count();
        
        array_push($estatisticas, $nAnuncios);
        

        $nPropostas = (new Query())
                ->select('id, id_anuncio')
                ->from(Proposta::tableName())
                ->groupBy('id_anuncio, id')
                ->average('id_anuncio');
        $nPropostas = round($nPropostas);
        
        array_push($estatisticas, $nPropostas);

        
        $nUtilizadores = (new Query())
                ->from(User::tableName())
                ->count();
        $nUtilizadores = $nUtilizadores-1;
        
        array_push($estatisticas, $nUtilizadores);


        $notifications = ['Notification 1', 'Notification 2'];

        $this->view->params['notifications'] = $notifications;
        $this->layout = 'main';

        return $this->render('index', ['stats' => $estatisticas]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(ArrayHelper::isIn('admin', Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))) {
                return $this->goHome();
            } else {
                return $this->redirect(Yii::$app->urlManagerFrontEnd->createUrl('site/login'));
            }
        }

        $this->layout = 'main-login';

        $model = new LoginForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->validateUser(Yii::$app->authManager->getRole('admin'))) {
                if ($model->login()) {
                    return $this->goBack();
                } else {
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->redirect(Yii::$app->urlManagerFrontEnd->createUrl('site/login'));
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
