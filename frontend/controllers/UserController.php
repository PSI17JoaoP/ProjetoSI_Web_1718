<?php

namespace frontend\controllers;

use frontend\models\PINGenerator;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use common\models\Anuncio;
use common\models\Cliente;
use common\models\Tools;
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
        
        //$model = new Cliente();
        //$model = Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]);
        
        $cliente = Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]);
        $model = new ClienteForm();


        if ($model->load(Yii::$app->request->post()) && $model->atualizar($cliente)) 
        {
            return $this->render('conta', 
            [
                'model' => $model, 
                'regioes' => Tools::listaRegioes(),
                'categorias' => Tools::listaCategorias(),
                'tipo' => "success", 
                'titulo' => "Sucesso!", 
                'mensagem' => "As suas informações de conta foram atualizadas com sucesso"
            ]);
        }else {
            $model->carregar($cliente);

            return $this->render('conta', 
            [
                'model' => $model, 
                'regioes' => Tools::listaRegioes(),
                'categorias' => Tools::listaCategorias(),
                'tipo' => null, 
                'titulo' => null, 
                'mensagem' => null
            ]);
        }
        
    }

    public function actionDetalhesContacto($idUser, $idUserProposta)
    {
        $user1 = Cliente::findOne(['id_user' => $idUser]);
        $user2 = Cliente::findOne(['id_user' => $idUserProposta]);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [$user1, $user2];
    }


    public function actionAnuncios($tipo = null, $titulo = null, $mensagem = null)
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->identity->getId()]);

        $gestorCategorias = new GestorCategorias();

        //$categorias = $gestorCategorias->getCategoriasDados($anuncios, 'cat_oferecer');
        $anunciosAtivos = [];
        $contactos = [];

        foreach($anuncios as $anuncio)
        {
            if ($anuncio->estado == "CONCLUIDO") 
            {
                $propostasAnuncio = $anuncio->propostas;

                if(!empty($propostasAnuncio)) 
                {
                    foreach ($propostasAnuncio as $key => $value)
                    {
                        if ($value->estado == "ACEITE")
                        {
                            $propostaAceite = $value;
                        }
                    }
                }

                $contacto = [
                    "titulo" => $anuncio->titulo, 
                    "dataConclusao" => $anuncio->data_conclusao,
                    "idUser" => Yii::$app->user->getId(),
                    "idUserProposta" => $propostaAceite->id_user,
                ];

                \array_push($contactos, $contacto);
            }else 
            {
                \array_push($anunciosAtivos, $anuncio);
            }
        }

        $categorias = $gestorCategorias->getCategoriasDados($anunciosAtivos, 'cat_oferecer');

        return $this->render('anuncios', [
            'anuncios' => $categorias,
            'anunciosConcluidos' => $contactos,            
            'tipo' => $tipo, 
            'titulo' => $titulo, 
            'mensagem' => $mensagem
        ]);
    }

    public function actionPropostas($tipo = null, $titulo = null, $mensagem = null)
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->getId()]);

        $gestorCategorias = new GestorCategorias();

        $propostas = [];

        foreach($anuncios as $anuncio)
        {
            $propostasAnuncio = $anuncio->propostas;

            if(!empty($propostasAnuncio)) {

                foreach ($propostasAnuncio as $key => $value) {
                    if ($value->estado == "PENDENTE") {
                        \array_push($propostas, $value);
                    }
                }
            }
            
        }

        $categorias = $gestorCategorias->getCategoriasDados($propostas, 'cat_proposto');

        return $this->render('propostas', [
            'propostas' => $categorias,
            'tipo' => $tipo, 
            'titulo' => $titulo, 
            'mensagem' => $mensagem
        ]);
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
        $modalModel = new ClienteForm();

        if($modalModel->load(Yii::$app->request->post()))
        {
            if($modalModel->guardar(Yii::$app->user->getId()))
            {
                return $this->render($viewPath, [
                    'model' => $model,
                    'catList' => Tools::listaCategorias(),
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
