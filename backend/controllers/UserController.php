<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Response;
use yii\web\Controller;
use common\models\User;
use common\models\Tools;
use common\models\Anuncio;
use common\models\Cliente;
use yii\filters\VerbFilter;
use common\models\Proposta;
use backend\models\PerfilForm;
use yii\filters\AccessControl;


class UserController extends Controller
{
   
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'perfil', 'detalhes'],
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

        $clientes = (new Query())
                    ->select(['id', 'email'])
                    ->from(User::tableName())
                    ->join('LEFT JOIN', Cliente::tableName(), user::TableName().".id = ".Cliente::tableName().".id_user")
                    ->addSelect('nome_completo')
                    ->all();

        return $this->render('index', ['clientes' => $clientes]);
    }

    public function actionDetalhes($id)
    {
        $user = User::findOne(['id' => $id]);
        $cliente = Cliente::findOne(['id_user' => $id]);

        $anuncios = null;
        
        if($cliente)
        {
            $cliente->regiao = Tools::listaRegioes()[$cliente->regiao];

            $anuncios = (new Query())
                    ->select('id, titulo, cat_oferecer, cat_receber')
                    ->from(Anuncio::tableName())
                    ->where(['id_user' => $id, 'estado' => 'ATIVO'])
                    ->all();
                
            foreach ($anuncios as $key => $anuncio) 
            {
                $anuncios[$key]['cat_oferecer'] = Tools::tipoCategoria($anuncio['cat_oferecer']);
                $anuncios[$key]['cat_receber'] = Tools::tipoCategoria($anuncio['cat_receber']);

                $nPropostas = (new Query())
                            ->from(Proposta::tableName())
                            ->where(['id_anuncio' => $anuncio['id']])
                            ->count();
                $anuncios[$key]["nPropostas"] = $nPropostas;
            }
        }
        

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['user' => $user, 'cliente' => $cliente, 'anuncios' => $anuncios];
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