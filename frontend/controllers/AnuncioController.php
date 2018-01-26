<?php

namespace frontend\controllers;

use Yii;

use yii\db\Query;
use yii\base\Model;
use yii\web\Response;
use yii\web\Controller;
use common\models\Tools;
use common\models\Anuncio;
use common\models\Cliente;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\models\Proposta;
use common\models\Categoria;
use yii\filters\AccessControl;
use frontend\models\AnuncioForm;
use common\models\ImagensAnuncio;
use common\models\CategoriaRoupa;
use common\models\CategoriaJogos;
use yii\web\NotFoundHttpException;
use common\models\CategoriaLivros;
use yii\web\ForbiddenHttpException;
use frontend\models\GestorCategorias;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaEletronica;
use common\models\CategoriaSmartphones;
use common\models\CategoriaComputadores;

/**
 * AnuncioController implements the CRUD actions for Anuncio model.
 */
class AnuncioController extends Controller
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
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['search', 'detalhes'],
                        'allow' => true,
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException('You are not allowed to access this page');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Searches for Anuncio models.
     * @param string $titulo
     * @param string $categoria
     * @param string $regiao
     * @return mixed
     */
    public function actionSearch($titulo = null, $categoria = null, $regiao = null)
    {
        $anuncios = (new Query())
            ->select('anuncios.id, anuncios.titulo, anuncios.id_user, cat_oferecer, cat_receber')
            ->from(Anuncio::tableName())
            ->join('JOIN', ImagensAnuncio::tableName(), Anuncio::tableName().'.id = '.ImagensAnuncio::tableName().'.anuncio_id')
            ->addSelect('path_relativo');

        //Filtrar categoria
        switch ($categoria)
        {
            case 'brinquedos':
                $anuncios = $anuncios->join('JOIN', CategoriaBrinquedos::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaBrinquedos::tableName().".id_categoria");
                break;
            case 'jogos':
                $anuncios = $anuncios->join('JOIN', CategoriaJogos::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaJogos::tableName().".id_brinquedo");
                break;
            case 'eletronica':
                $anuncios = $anuncios->join('JOIN', CategoriaEletronica::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaEletronica::tableName().".id_categoria");
                break;
            case 'computadores':
                $anuncios = $anuncios->join('JOIN', CategoriaComputadores::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaComputadores::tableName().".id_eletronica");
                break;
            case 'smartphones':
                $anuncios = $anuncios->join('JOIN', CategoriaSmartphones::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaSmartphones::tableName().".id_eletronica");
                break;
            case 'livros':
                $anuncios = $anuncios->join('JOIN', CategoriaLivros::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaLivros::tableName().".id_categoria");
                break;
            case 'roupa':
                $anuncios = $anuncios->join('JOIN', CategoriaRoupa::tableName(), Anuncio::tableName().".cat_oferecer = ". CategoriaRoupa::tableName().".id_categoria");
        }

        //Filtrar região
        if(in_array($regiao, Tools::listaRegioes()))
        {
            $anuncios = $anuncios->join('JOIN', Cliente::tableName(), Anuncio::tableName().".id_user = ". Cliente::tableName().".id_user");
            $anuncios = $anuncios->where('regiao=:regiao', [':regiao' => $regiao]);

            if ($titulo != null) 
            {    
                $anuncios = $anuncios->andWhere(['like', 'titulo', $titulo]);
            }
        }

        //Filtrar título
        else if ($titulo != null)
        {
            $anuncios = $anuncios->Where(['like', 'titulo', $titulo]);
        }

        $anuncios = $anuncios->andWhere(['not', 'estado=:estado'], [':estado' => "CONCLUIDO"]);
        $anuncios = $anuncios->all();

        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $anuncios;
        }

        else
        {
            return $this->render('pesquisa', [
                'anuncios' => $anuncios,
                'regioes' => Tools::listaRegioes(),
                'categorias' => Tools::listaCategorias()
            ]);
        }
    }

    /**
     * Retorna os detalhes de um anúncio com base no id recebido
     */
    public function actionDetalhes($id)
    {
        $gestor = new GestorCategorias();

        //$anuncio = (new Query())->from(Anuncio::tableName())->where('id = :id', [':id' => $id])->all();
        $anuncio = Anuncio::findOne('id = ' . $id);

        $categoriaO = $gestor->getCategorias($anuncio, 'cat_oferecer');
        $categoriaOBase = array_shift($categoriaO);

        $catO = Tools::novaCategoria($categoriaOBase->id);
        
        $n = count($categoriaO);

        for ($i=0; $i < $n; $i++)
        { 
            foreach ($categoriaO[$i] as $key => $value) 
            {
                if (in_array($key, ['id_categoria', 'id_brinquedo', 'id_eletronica']))
                {
                    $value = Tools::tipoCategoria($categoriaOBase->id);
                }

                if(isset($catO->attributeLabels()[$key]))
                    $categoriaO[$n][$catO->attributeLabels()[$key]] = $value;

                unset($categoriaO[$i][$key]);
            }
        }

        $categoriaR = $gestor->getCategorias($anuncio, 'cat_receber');

        if($categoriaR)
        {
            $categoriaRBase = array_shift($categoriaR);

            $catR = Tools::novaCategoria($categoriaRBase->id);
            
            $n = count($categoriaR);

            for ($i=0; $i < $n; $i++) 
            { 
                foreach ($categoriaR[$i] as $key => $value) 
                {
                    if (in_array($key, ['id_categoria', 'id_brinquedo', 'id_eletronica']))
                    {
                        $value = Tools::tipoCategoria($categoriaOBase->id);
                    }

                    if(isset($catR->attributeLabels()[$key]))
                        $categoriaR[$n][$catR->attributeLabels()[$key]] = $value;

                    unset($categoriaR[$i][$key]);
                }
            }
        } else {
            $categoriaRBase = ['nome' => "Aberto a sugestões"];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [$anuncio, $categoriaOBase, $categoriaO, $categoriaRBase, $categoriaR];
    }

    /**
     * Creates a new Anuncio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnuncioForm();

        //Validar estado de conta do cliente. SE for o seu 1º anúncio, mostrar popup de informações extra
        if (Cliente::findOne(['id_user' => Yii::$app->user->identity->getId()]) === null)
        {
            Yii::$app->runAction('user/cliente', [
                'viewPath' => 'anuncio/create',
                'model' => $model,
            ]);
        }
        
        //Validar a escolha da categoria do evento onChange (Oferta)
        if(Yii::$app->request->get('catOferta') !== 'null')
        {   
            $cat = Yii::$app->request->get('catOferta');
            $model->catOferta = $cat;

            $model->mOferta = $model->selecionarCategoria($cat);
        }

        //Validar a escolha da categoria do evento onChange (Procura)
        if(Yii::$app->request->get('catProcura') !== 'null')
        {   
            $cat = Yii::$app->request->get('catProcura');
            $model->catProcura = $cat;

            $model->mProcura = $model->selecionarCategoria($cat);
        }
    
        //Validar envio de dados
        if ($model->load(Yii::$app->request->post())) 
        {
            $catOferta = $model->catOferta;
            $catProcura = $model->catProcura;

            $model->mOferta = $model->selecionarCategoria($catOferta);
            $model->mProcura = $model->selecionarCategoria($catProcura);

            if ($catOferta === $catProcura) {

                $data = array(
                    '0' => $model->selecionarCategoria($catOferta), 
                    '1' => $model->selecionarCategoria($catProcura)
                );

                if (Model::loadMultiple($data, Yii::$app->request->post())) {
                    $model->mOferta = $data['0'];
                    $model->mProcura = $data['1'];
                }
            }

            else
            {
                //Oferta
                $dataO = array(
                    '0' => $model->selecionarCategoria($catOferta)
                );

                if (Model::loadMultiple($dataO, Yii::$app->request->post())) {
                    $model->mOferta = $dataO['0'];
                }

                //Procura
                if($catProcura !== 'todos') {

                    $dataP = array(
                        '1' => $model->selecionarCategoria($catProcura)
                    );

                    if(Model::loadMultiple($dataP, Yii::$app->request->post())) {
                        $model->mProcura = $dataP['1'];
                    }
                }
            }

            //Validar o pedido AJAX do evento onChange e validar o formulário com os novos dados
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            else if (($modeloOferta = $model->mOferta->guardar()) && ($modeloProcura = $model->mProcura->guardar()))
            {
                if (($modelo = $model->guardar(Yii::$app->user->identity->getId(), $modeloOferta, $modeloProcura))) 
                {
                    return $this->redirect(['user/anuncios', 
                        'tipo' => "success",
                        'titulo' => "Sucesso!",
                        'mensagem' => "O seu anúncio foi criado com sucesso"
                        
                    ]);
                      
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'catList' => Tools::listaCategorias(),
                    ]);
                }
            }

            else
            {
                return $this->render('create', [
                    'model' => $model,
                    'catList' => Tools::listaCategorias(),
                ]);
            }
        }

        else
        {
            return $this->render('create', [
                'model' => $model,
                'catList' => Tools::listaCategorias(),
            ]);
        }
    }

    /**
     * Deletes an existing Anuncio model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($id != null) 
        {
            $anuncio = Anuncio::findOne(['id' => $id]);

            if($anuncio != null) 
            {

                $gestor = new GestorCategorias();

                $categoriasRemover = array();
                
                \array_push($categoriasRemover, $anuncio->cat_oferecer);
                if ($anuncio->cat_receber != null) 
                {
                    \array_push($categoriasRemover, $anuncio->cat_receber);
                }

                ImagensAnuncio::deleteAll('anuncio_id='.$anuncio->id);
                

                $propostasRemover = Proposta::findAll(["id_anuncio" => $anuncio->id]);

                foreach ($propostasRemover as $proposta) 
                {
                    \array_push($categoriasRemover, $proposta->cat_proposto);
                }

                Proposta::deleteAll('id_anuncio='.$anuncio->id);

                if ($anuncio->delete()) 
                {
                    foreach ($categoriasRemover as $categoria) 
                    {
                        $base = Categoria::findOne(["id" => $categoria]);
                        
                        if($base)
                        {
                            if ($base->cRoupa) 
                            {
                                $base->cRoupa->delete();
                            }
                            if ($base->cLivros) 
                            {
                                $base->cLivros->delete();
                            }

                            if ($base->cEletronica) 
                            {
                                if ($base->cEletronica->cComputadores) 
                                {
                                    $base->cEletronica->cComputadores->delete();
                                }else if ($base->cEletronica->cSmartphones)
                                {
                                    $base->cEletronica->cSmartphones->delete();
                                }

                                $base->cEletronica->delete();
                            }

                            if ($base->cBrinquedos) 
                            {
                                if ($base->cBrinquedos->cJogos) 
                                {
                                    $base->cBrinquedos->delete();
                                }

                                $base->cBrinquedos->delete();
                            }

                            $base->delete();
                        }
                    }

                    return $this->redirect(['user/anuncios', 
                        'tipo' => "success",
                        'titulo' => "Sucesso!",
                        'mensagem' => "O seu anúncio foi removido com sucesso"
                    ]);
                }
            }
        }

        return $this->redirect(['user/anuncios',
            'tipo' => "danger",
            'titulo' => "Atenção!",
            'mensagem' => "Não foi possível eliminar o seu anúncio"
        ]);
    }

    /**
     * Finds the Anuncio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anuncio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anuncio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
