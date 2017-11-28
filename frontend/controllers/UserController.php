<?php

namespace frontend\controllers;

use frontend\models\PINGenerator;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Anuncio;
use common\models\Cliente;
use frontend\models\ClienteForm;
use frontend\models\GestorCategorias;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'history', 'anuncios', 'propostas', 'conta'],
                'rules' => [
                    [
                        'actions' => ['index', 'history', 'anuncios', 'propostas', 'conta'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
                ],

                'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
                }
            ],
        ];
    }

    public function actionConta()
    {
        $this->layout = "main-user";

        $arrayRegiao = array('aveiro' => "Aveiro",
                            'beja' => "Beja",
                            'braga' => "Braga",
                            'bragança' => "Bragança",
                            'castelo branco' => "Castelo Branco",
                            'coimbra' => "Coimbra",
                            'evora' => "Évora",
                            'faro' => "Faro",
                            'guarda' => "Guarda",
                            'leiria' => "Leiria",
                            'lisboa' => "Lisboa",
                            'portalegre' => "Portalegre",
                            'porto' => "Porto",
                            'santarem' => "Santarém",
                            'setubal' => "Setúbal",
                            'viana do castelo' => "Viana do Castelo",
                            'vila real' => "Vila Real",
                            'viseu' => "Viseu",
                            'acores' => "Açores",
                            'madeira' => "Madeira"
                            );
        
        $model = new Cliente();

        return $this->render('conta', ['model' => $model, 'regioes' => $arrayRegiao]);
    }

    public function actionAnuncios()
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->identity->getId()]);

        $gestorCategorias = new GestorCategorias();

        $categorias = $gestorCategorias->getCategoriasDados($anuncios, 'cat_oferecer');

        return $this->render('anuncios', ['anuncios' => $categorias]);
    }

    public function actionPropostas()
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->getId()]);

        $gestorCategorias = new GestorCategorias();

        $propostas = [];

        foreach($anuncios as $anuncio)
        {
            $propostasAnuncio = $anuncio->propostas;

            if(!empty($propostasAnuncio)) {
                $propostas = array_merge($propostas, $propostasAnuncio);
            }
        }

        $categorias = $gestorCategorias->getCategoriasDados($propostas, 'cat_proposto');

        return $this->render('propostas', ['propostas' => $categorias]);
    }

    public function actionHistory()
    {
        $this->layout = "main-user";

        return $this->render('history');
    }

    public function actionPin()
    {
        $this->layout = "main-user";

        $model = Cliente::findOne(['id_user' => Yii::$app->user->getId()]);

        if(Yii::$app->request->get('id') !== null) {

            $pinGenerator = new PINGenerator();

            do
            {
                $keyPIN = $pinGenerator->generate();
            }
            while (Cliente::findOne(['pin' => $keyPIN]));

            $model->pin = $keyPIN;

            if($model->save()) {
                return $this->render('pin', ['model' => $model]);
            } else {
                return $this->render('pin', ['model' => $model]);
            }
        }

        return $this->render('pin', ['model' => $model]);
    }

    public function actionCliente($model, $viewPath)
    {
        $listaCategorias = array('brinquedos' => "Brinquedos" ,
            'jogos' => "Jogos",
            'eletronica' => "Eletrónica",
            'computadores' => "Computadores",
            'smartphones' => "Smartphones",
            'livros' => "Livros",
            'roupa' => "Roupa");

        $modalModel = new ClienteForm();

        if($modalModel->load(Yii::$app->request->post()))
        {
            if($modalModel->guardar(Yii::$app->user->getId()))
            {
                return $this->render($viewPath, [
                    'model' => $model,
                    'catList' => $listaCategorias,
                ]);
            }
        }

        echo $this->renderAjax('//modals/modal',[
            'header' => 'Adicionar informações de conta',
            'backdrop' => 'static',
            'keyboard' => 'false',
            'options' => [
                'model' => $modalModel
            ],
            'content' => '//forms/cliente'
        ]);

        return false;
    }
}
