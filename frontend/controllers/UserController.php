<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Cliente;
use common\models\Anuncio;
use common\models\Categoria;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaComputadores;
use common\models\CategoriaEletronica;
use common\models\CategoriaJogos;
use common\models\CategoriaLivros;
use common\models\CategoriaRoupa;
use common\models\CategoriaSmartphones;
use frontend\models\ClienteForm;

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

        $categoriasPropostas = array();

        foreach ($anuncios as $anuncio)
        {
            $propostas = $anuncio->propostas;

            foreach ($propostas as $proposta)
            {
                $dados[] = Categoria::findAll(['id' => $proposta->cat_proposto]);

                if(($categorias = CategoriaRoupa::findAll(['id_categoria' => $proposta->cat_proposto])))
                {
                    $dados[] = $categorias;
                }

                if(($categorias = CategoriaLivros::findAll(['id_categoria' => $proposta->cat_proposto])))
                {
                    $dados[] = $categorias;
                }

                if(($categorias = CategoriaEletronica::findAll(['id_categoria' => $proposta->cat_proposto])))
                {
                    $dados[] = $categorias;

                    if(($categorias = CategoriaComputadores::findAll(['id_eletronica' => $proposta->cat_proposto])))
                    {
                        $dados[] = $categorias;
                    }

                    if(($categorias = CategoriaSmartphones::findAll(['id_eletronica' => $proposta->cat_proposto])))
                    {
                        $dados[] = $categorias;
                    }
                }

                if(($categorias = CategoriaBrinquedos::findAll(['id_categoria' => $proposta->cat_proposto])))
                {
                    $dados[] = $categorias;

                    if(($categorias = CategoriaJogos::findAll(['id_brinquedo' => $proposta->cat_proposto])))
                    {
                        $dados[] = $categorias;
                    }
                }

                \array_push($categoriasPropostas, $dados);
            }
        }

        var_dump($categoriasPropostas);

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
            'id' => 'modal_cliente',
            'header' => 'Adicionar informações de conta',
            'backdrop' => 'static',
            'keyboard' => 'false',
            'model' => $modalModel,
            'content' => '//forms/cliente'
        ]);
    }
}
