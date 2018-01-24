<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\base\Exception;
use common\models\Tools;
use yii\web\UploadedFile;
use common\models\Cliente;
use common\models\Anuncio;
use common\models\Proposta;
use yii\filters\AccessControl;
use common\models\Notificacoes;
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
                'rules' => [
                    [
                        'actions' => ['index', 'historico', 'anuncios', 'propostas', 'conta', 'detalhes-contacto', 'pin', 'avaliar'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
                    [
                        'actions' => ['cliente'],
                        'allow' => true,
                    ],
                ],

                'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
                }
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $notifications = array();

        if (!Yii::$app->user->isGuest) 
        {
            $notifications = Notificacoes::findAll(["id_user" => Yii::$app->user->identity->getId(), "lida" => '0']);
        }

        $this->view->params['notifications'] = $notifications;

        return true; 
    }

    public function actionConta($tipo = null, $titulo = null, $mensagem = null)
    {
        $this->layout = "main-user";

        
        $cliente = Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]);

        $model = new ClienteForm();


        if ($model->load(Yii::$app->request->post())) 
        {
            
            if ($cliente == null) {
                $cliente = new Cliente();
                $cliente->id_user = Yii::$app->user->identity->getId();
            }

            if($model->atualizar($cliente))
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
            }else
            {
                return $this->render('conta', 
                [
                    'model' => $model, 
                    'regioes' => Tools::listaRegioes(),
                    'categorias' => Tools::listaCategorias(),
                    'tipo' => "warning", 
                    'titulo' => "Erro!", 
                    'mensagem' => "Não foi possível atualizar o seu perfil de cliente"
                ]);
            }
        }else {

            if ($cliente !== null) 
            {
                $model->carregar($cliente);
            }
            
            return $this->render('conta', 
            [
                'model' => $model, 
                'regioes' => Tools::listaRegioes(),
                'categorias' => Tools::listaCategorias(),
                'tipo' => $tipo, 
                'titulo' => $titulo, 
                'mensagem' => $mensagem
            ]);
        }
        
    }

    public function actionDetalhesContacto($idUser, $idUserProposta)
    {
        $user1 = Cliente::findOne(['id_user' => $idUser]);
        $user2 = Cliente::findOne(['id_user' => $idUserProposta]);

        $regioes = Tools::listaRegioes();
        $user2->regiao = $regioes[$user2->regiao];

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
        $anunciosFechados = [];
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
                    "path" => "",
                ];

                if ($anuncio->imagensAnuncios != null) {
                    $contacto["path"] = $anuncio->imagensAnuncios[0]->path_relativo;
                }

                \array_push($contactos, $contacto);

            }else if ($anuncio->estado == "FECHADO") 
            {
                \array_push($anunciosFechados, $anuncio);
            } 
            {
                \array_push($anunciosAtivos, $anuncio);
            }
        }

        $categorias = $gestorCategorias->getCategoriasDados($anunciosAtivos, 'cat_oferecer');
        $categoriasFechadas = $gestorCategorias->getCategoriasDados($anunciosFechados, 'cat_oferecer');

        return $this->render('anuncios', [
            'anuncios' => $categorias,
            'anunciosConcluidos' => $contactos, 
            'anunciosFechados' => $categoriasFechadas,           
            'tipo' => $tipo, 
            'titulo' => $titulo, 
            'mensagem' => $mensagem
        ]);
    }

    public function actionPropostas($tipo = null, $titulo = null, $mensagem = null, $id_notificacao = null)
    {
        $this->layout = "main-user";

        //Marcar notificação como lida, se for o caso
        if ($id_notificacao != null) 
        {
            $notificacao = Notificacoes::findOne(["id" => $id_notificacao]);
            $notificacao->ler();
        }

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->getId()]);

        $gestorCategorias = new GestorCategorias();

        $propostas = [];
        $contactos = [];

        foreach($anuncios as $anuncio)
        {
            $propostasAnuncio = $anuncio->propostas;

            if(!empty($propostasAnuncio)) 
            {

                foreach ($propostasAnuncio as $key => $value)
                {
                    if ($value->estado == "PENDENTE") 
                    {
                        \array_push($propostas, $value);
                    }
                }
            }
        }

        $minhasPropostas = Proposta::findAll(['id_user' => Yii::$app->user->getId(), 'estado' => "ACEITE"]);

        foreach($minhasPropostas as $minhaProposta)
        {
            $contacto = [
                "titulo" => $minhaProposta->idAnuncio->titulo, 
                "dataConclusao" => $minhaProposta->idAnuncio->data_conclusao,
                "idUser" => Yii::$app->user->getId(),
                "idUserAnuncio" =>$minhaProposta->idAnuncio->id_user,
            ];

            \array_push($contactos, $contacto);
        }

        $categorias = $gestorCategorias->getCategoriasDados($propostas, 'cat_proposto');

        return $this->render('propostas', [
            'propostas' => $categorias,
            'propostasAceites' => $contactos,
            'tipo' => $tipo, 
            'titulo' => $titulo, 
            'mensagem' => $mensagem
        ]);
    }

    public function actionHistorico()
    {
        $this->layout = "main-user";

        $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->identity->getId()]);

        $propostas = Proposta::findAll(['id_user' => Yii::$app->user->identity->getId()]);

        $gestorCategorias = new GestorCategorias();
        
        $categorias = $gestorCategorias->getCategoriasDados($propostas, 'cat_proposto');              

        return $this->render("historico", [
        'anuncios' => $anuncios,
        'propostas' => $categorias,
        ]);

    }

    public function actionPin()
    {
        $this->layout = "main-user";

        $model = Cliente::findOne(['id_user' => Yii::$app->user->getId()]);

        if ($model === null)
        {
           return $this->redirect(['conta', 
                'tipo' => "warning", 
                'titulo' => "Aviso!", 
                'mensagem' => "Complete o seu perfil de cliente antes de gerar um pin"
           ]);
        }

        if(Yii::$app->request->get('id') !== null) {

            do
            {
                $keyPIN = strtoupper(Yii::$app->getSecurity()->generateRandomString(5));
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

    public function actionCliente($model = null, $viewPath)
    {
        $modalModel = new ClienteForm();

        if($modalModel->load(Yii::$app->request->post()))
        {
            if($modalModel->guardar(Yii::$app->user->getId()))
            {
                return $this->redirect([$viewPath, 
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

    public function actionAvaliar($id_cliente, $score)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cliente = Cliente::findOne(["id_user" => $id_cliente]);

        if ($cliente) 
        {
            $cliente->n_reviews += 1;
            $cliente->total_score += ($score*10 * 2);
            
            if($cliente->save(false))
            {
                return true;
            }
        }

        return false;
    }
}