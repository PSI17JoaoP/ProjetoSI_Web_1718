<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Response;
use common\models\User;
use yii\web\Controller;
use common\models\Tools;
use common\models\Anuncio;
use common\models\Cliente;
use yii\filters\VerbFilter;
use common\models\Proposta;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\filters\AccessControl;
use common\models\CategoriaPreferida;

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
                        'actions' => ['logout', 'index', 'pie-info', 'anuncios', 'propostas'],
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

        //Todos
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
        //---------------------------------------

        //Anuncios
        $nAnunciosMes = (new Query())
                ->from(Anuncio::tableName())
                ->where('MONTH(data_criacao) = MONTH(CURRENT_DATE)')
                ->count();
        array_push($estatisticas, $nAnunciosMes);


        $nAnunciosCat = [];
        $listaCat = Tools::listaCategorias();

        foreach ($listaCat as $key => $cat) 
        {
            $subQuery = (new Query())
                    ->from('c_'.$key)
                    ->all();
            
            $lista = [];
            foreach ($subQuery as $i => $value) {
                array_push($lista, \array_values($value)[0]);
            }

            $catCount = [$key =>(new Query())
                    ->from(Anuncio::tableName())
                    ->where(['in', 'cat_oferecer', $lista])
                    ->count()];
            
            array_push($nAnunciosCat, $catCount);
        }
        array_push($estatisticas, $nAnunciosCat);
        //---------------------------------------

        //Propostas

        $nPropostasPendentes = (new Query())
                ->from(Proposta::tableName())
                ->where('estado = :estado', [':estado' => 'PENDENTE'])
                ->count();
        
        array_push($estatisticas, $nPropostasPendentes);
        //---------------------------------------
        
        //Utilizadores

        $idUserMAnuncios = (new Query())
                    ->select('id_user')
                    ->from(Anuncio::tableName())
                    ->groupBy('id_user')
                    ->count('id_user');
        
        $userMAnuncios = User::findOne(['id' => $idUserMAnuncios[0]])->username;

        array_push($estatisticas, $userMAnuncios);

        $catPopular = (new Query())
                    ->select('categoria')
                    ->from(CategoriaPreferida::tableName())
                    ->groupBy('categoria')
                    ->one();

        array_push($estatisticas, $listaCat[$catPopular['categoria']]);

        return $this->render('index', ['stats' => $estatisticas]);
    }

    /**
     * Informação para alimentar o gráfico circular presente no index
     */
    public function actionPieInfo()
    {
        if (Yii::$app->request->isAjax)
        {
            $dados = [];
            $listaCat = Tools::listaCategorias();

            foreach ($listaCat as $key => $cat) 
            {
                $subQuery = (new Query())
                        ->from('c_'.$key)
                        ->all();
                
                $listaID = [];
                foreach ($subQuery as $i => $value) {
                    array_push($listaID, \array_values($value)[0]);
                }

                $catCount = [$key =>(new Query())
                        ->from(Anuncio::tableName())
                        ->where(['in', 'cat_oferecer', $listaID])
                        ->count()];
                
                array_push($dados, $catCount);
            }
            
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $dados;
        }
    }

    /**
     * Estatísticas detalhadas sobre anúncios
     */
    public function actionAnuncios()
    {

        if (Yii::$app->request->isAjax) 
        {
            $dados = [];
            $anunciosMes = (new Query())
                ->select('MONTH(data_criacao) as "mes", COUNT(id) as "count"')
                ->from(Anuncio::tableName())
                ->where('MONTH(data_criacao) - MONTH(CURRENT_DATE) < 6')
                ->groupBy('MONTH(data_criacao)')
                ->all();
            
            $mesesPT = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
            $mesAtual = \date('m');

            for ($i = $mesAtual-5; $i <= $mesAtual ; $i++) 
            { 
                $dado = ["mes" => $mesesPT[$i-1], "count" => 0];

                foreach ($anunciosMes as $key => $anuncio) 
                {
                    if($anuncio["mes"] == $i)
                    {
                        $dado = ["mes" => $mesesPT[$i-1], "count" => $anuncio["count"]];
                    }
                }
                \array_push($dados, $dado);
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $dados;
        }else
        {
            return $this->render('anuncios');
        }
    }

    /**
     * Estatísticas detalhadas sobre propostas
     */
    public function actionPropostas()
    {
        if (Yii::$app->request->isAjax) 
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $dados;
        }else
        {
            return $this->render('propostas');
        }
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
