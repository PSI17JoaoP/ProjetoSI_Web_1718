<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\PerfilForm;
use common\models\Cliente;
use common\models\User;
use common\models\Tools;
use common\models\Anuncio;
use yii\web\Response;


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

            $anuncios = Anuncio::findAll(['id_user' => $id, 'estado' => 'ATIVO']);
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