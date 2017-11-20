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
use common\models\User;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ClienteForm;

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
        $listaCategorias = array(
            'brinquedos' => "Brinquedos",
            'jogos' => "Jogos",
            'eletronica' => "Eletrónica",
            'computadores' => "Computadores",
            'smartphones' => "Smartphones",
            'livros' => "Livros",
            'roupa' => "Roupa"
        );

        $listaRegioes = array(
            'Aveiro' => "Aveiro",
            'Beja' => "Beja",
            'Braga' => "Braga",
            'Bragança' => "Bragança",
            'Castelo Branco' => "Castelo Branco",
            'Coimbra' => "Coimbra",
            'Évora' => "Évora",
            'Faro' => "Faro",
            'Guarda' => "Guarda",
            'Leiria' => "Leiria",
            'Lisboa' => "Lisboa",
            'Portalegre' => "Portalegre",
            'Porto' => "Porto",
            'Santarém' => "Santarém",
            'Setúbal' => "Setúbal",
            'Viana do Castelo' => "Viana do Castelo",
            'Vila Real' => "Vila Real",
            'Viseu' => "Viseu",
            'Açores' => "Açores",
            'Madeira' => "Madeira",
        );

        $anunciosRecentes = Anuncio::find()->all();

        $anunciosDestaques = Anuncio::find()->all();

        if(!Yii::$app->user->isGuest)
        {

            $user = User::findOne(['id' => Yii::$app->user->getId()]);

            $model = new ClienteForm();

            if($user->cliente === null)
            {
                if($model->load(Yii::$app->request->post()))
                {
                    if($model->guardar(Yii::$app->user->getId()))
                    {
                        if(Yii::$app->request->post('botao') === 'anuncio') {
                            $this->redirect(['anuncio/create']);
                        }

                        elseif(Yii::$app->request->post('botao') === 'proposta-get') {
                            $this->redirect(['proposta/create', 'anuncio' => Yii::$app->request->post('anuncio')]);
                        }
                    }
                    else
                    {
                        return $this->render('index', [
                            'model' => $model,
                            'anunciosRecentes' => $anunciosRecentes,
                            'anunciosDestaques' => $anunciosDestaques,
                            'categorias' => $listaCategorias,
                            'regioes' => $listaRegioes,
                        ]);
                    }
                }
                else
                {
                    return $this->render('index', [
                        'model' => $model,
                        'anunciosRecentes' => $anunciosRecentes,
                        'anunciosDestaques' => $anunciosDestaques,
                        'categorias' => $listaCategorias,
                        'regioes' => $listaRegioes,
                    ]);
                }
            }
            else
            {
                return $this->render('index', [
                    'model' => $model,
                    'anunciosRecentes' => $anunciosRecentes,
                    'anunciosDestaques' => $anunciosDestaques,
                    'categorias' => $listaCategorias,
                    'regioes' => $listaRegioes,
                ]);
            }
        }
        else
        {
            return $this->render('index', [
                'anunciosRecentes' => $anunciosRecentes,
                'anunciosDestaques' => $anunciosDestaques,
                'categorias' => $listaCategorias,
                'regioes' => $listaRegioes,
            ]);
        }
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

        if($model->load(Yii::$app->request->post())) {
            if ($model->validateUser(Yii::$app->authManager->getRole('cliente'))) {
                if ($model->login()) {
                    return $this->goBack();
                } else {
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->redirect(Yii::$app->urlManagerBackEnd->createUrl('site/login'));
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
     * Displays contact page.
     *
     * @return mixed
     */
    /*public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

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

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
