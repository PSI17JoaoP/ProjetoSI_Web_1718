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
use common\models\Reports;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Notificacoes;


class ReportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'fechar'],
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

    public function actionIndex()
    {
        $anunciosReportados = (new Query())
                ->select('anuncios.id, titulo, cat_oferecer, cat_receber, count(reports.id) as "nReports"')
                ->from(Anuncio::tableName())
                ->join("JOIN", Reports::tableName(), Anuncio::tableName().'.id = '.Reports::tableName().'.id_anuncio')
                ->where(['estado' => 'ATIVO'])
                ->orderBy('nReports')
                ->groupBy('anuncios.id')
                ->all();
            
        foreach ($anunciosReportados as $key => $anuncio) 
        {
            $anunciosReportados[$key]['cat_oferecer'] = Tools::tipoCategoria($anuncio['cat_oferecer']);
            $anunciosReportados[$key]['cat_receber'] = Tools::tipoCategoria($anuncio['cat_receber']);
        }
        return $this->render('index', ["dados" => $anunciosReportados]);
    }

    public function actionFechar($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $anuncio = Anuncio::findOne(['id' => $id]);

        $anuncio->estado = "FECHADO";

        if ($anuncio->save())
        {
            $notificar = new Notificacoes();
            $notificar->id_user = $anuncio->id_user;
            $notificar->mensagem = "O seu anúncio '$anuncio->titulo' foi fechado devido a um ou mais reports";

            $usersIDs = (new Query())
                    ->select('id_user')
                    ->from(Reports::tableName())
                    ->where(['id_anuncio' => $anuncio->id])
                    ->all();
            
            foreach ($usersIDs as $key => $user) 
            {
                $note = new Notificacoes();
                $note->id_user = $user["id_user"];
                $note->mensagem = "O anúncio '$anuncio->titulo' foi fechado graças ao seu report";
                $note->save();
            }

            if ($notificar->save()) 
            {
                $cliente = Cliente::findOne(['id_user' => $anuncio->id_user]);

                $cliente->total_score -= 10;
                
                if ($cliente->save()) 
                {
                    return true;
                }
            }     
        }

        return false;
    }
}