<?php
namespace frontend\controllers;

use common\models\Anuncio;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Tools;
use common\models\CategoriaPreferida;
use frontend\models\SignupForm;
use yii\db\Query;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaComputadores;
use common\models\CategoriaEletronica;
use common\models\CategoriaJogos;
use common\models\CategoriaLivros;
use common\models\CategoriaRoupa;
use common\models\CategoriaSmartphones;
use common\models\ImagensAnuncio;


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
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest) {

            //RECENTES

            $anunciosRecentes = (new Query())
                ->select(['anuncios.id', 'cat_oferecer', 'cat_receber'])
                ->from(Anuncio::tableName())
                ->where('id_user != :id_user', [':id_user' => Yii::$app->user->getId()])
                ->andWhere('estado != :estado', [':estado' => "CONCLUIDO"])
                ->join('JOIN', ImagensAnuncio::tableName(), Anuncio::tableName().'.id = '.ImagensAnuncio::tableName().'.anuncio_id')
                ->addSelect('path_relativo')
                ->orderBy(Anuncio::tableName().'.id DESC')
                ->limit(5)
                ->all();


            //SUGERIDOS

            $catPreferidas = CategoriaPreferida::find()
                ->select('categoria')
                ->where('id_user = :id_user', [':id_user' => Yii::$app->user->getId()])
                ->asArray()
                ->all();


            $anunciosNotUser = (new Query())
                ->select(['anuncios.id', 'cat_oferecer', 'cat_receber'])
                ->from(Anuncio::tableName())
                ->where('id_user != :id_user', [':id_user' => Yii::$app->user->getId()])
                ->andWhere('estado != :estado', [':estado' => "CONCLUIDO"])
                ->join('JOIN', ImagensAnuncio::tableName(), Anuncio::tableName().'.id = '.ImagensAnuncio::tableName().'.anuncio_id')
                ->addSelect(ImagensAnuncio::tableName().'.path_relativo');
                
            $anunciosDestaques = (new Query())
                ->from(['table' => $anunciosNotUser]);

            foreach ($catPreferidas as $key => $value) 
            {
                $stupidList = (new Query());
                $goodList = array();

                switch ($value['categoria']) 
                {
                    case 'brinquedos':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaBrinquedos::tableName())->all();
                        break;
                    case 'jogos':
                        $stupidList = $stupidList->select('id_brinquedo')->from(CategoriaJogos::tableName())->all();
                        break;
                    case 'eletronica':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaEletronica::tableName())->all();
                        break;
                    case 'computadores':
                        $stupidList = $stupidList->select('id_eletronica')->from(CategoriaComputadores::tableName())->all();                    
                        break;
                    case 'smartphones':
                        $stupidList = $stupidList->select('id_eletronica')->from(CategoriaSmartphones::tableName())->all();                    
                        break;
                    case 'livros':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaLivros::tableName())->all();
                        break;
                    case 'roupa':
                        $stupidList = $stupidList->select('id_categoria')->from(CategoriaRoupa::tableName())->all();
                }

                
                foreach ($stupidList as $key => $value) {
                    \array_push($goodList,  $value[\key($value)]);
                    
                }

                $anunciosDestaques = $anunciosDestaques->orWhere(['IN', 'cat_oferecer', $goodList]);
            }

        
            $anunciosDestaques = $anunciosDestaques->orderBy('table.id DESC')->distinct()->limit(5)->all();

        }

        else {
            $anunciosRecentes = Anuncio::find()
                ->orderBy('id DESC')
                ->limit(5)
                ->all();

            $anunciosDestaques = Anuncio::find()
                ->orderBy('id DESC')
                ->limit(5)
                ->all();
        }

        return $this->render('index', [
            'anunciosRecentes' => $anunciosRecentes,
            'anunciosDestaques' => $anunciosDestaques,
            'categorias' => Tools::listaCategorias(),
            'regioes' => Tools::listaRegioes(),
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(ArrayHelper::isIn('admin', Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()))) {
                return $this->goHome();
            } else {
                return $this->redirect(Yii::$app->urlManagerBackEnd->createUrl(['site/login']));
            }
        }

        $model = new LoginForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->validateUser(Yii::$app->authManager->getRole('cliente'))) {
                if ($model->login()) {
                    return $this->goBack();
                } else {
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                }
            } else if($model->validateUser(Yii::$app->authManager->getRole('admin'))){
                return $this->redirect(Yii::$app->urlManagerBackEnd->createUrl('site/login'));
            }else{
                return $this->render('login', [
                    'model' => $model,
                    
                ]);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    /*public function actionAbout()
    {
        return $this->render('about');
    }*/

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

}
