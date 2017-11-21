<?php

namespace frontend\controllers;

use common\models\Categoria;
use frontend\models\ClienteForm;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Cliente;
use common\models\Proposta;
use common\models\Anuncio;

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
                        'roles' => ['@'],
                    ],
                ],

                'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
                }
            ],
        ];
    }

    public function actionHistory()
    {
        $this->layout = "main-user";

        return $this->render('history');
    }

    public function actionPropostas()
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->getId()]);

        foreach ($anuncios as $anuncio)
        {
            $propostas = $anuncio->propostas;

            foreach ($propostas as $proposta)
            {
                $dados = [];
            }
        }

        return $this->render('propostas');
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

        return $this->render('anuncios', ['anuncios' => $anuncios]);
    }

    public function actionCliente($model, $controllerID)
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
                return $this->render($controllerID . 'create', [
                    'model' => $model,
                    'catList' => $listaCategorias,
                ]);
            }
        }

        echo $this->renderAjax('//modals/modal',[
            'header' => 'Adicionar informações de conta',
            'model' => $modalModel,
            'content' => '//forms/cliente'
        ]);
    }
}
