<?php

namespace api\controllers;

use common\models\TipoRoupas;
use Yii;

use common\models\User;
use common\models\Cliente;
use common\models\Categoria;
use common\models\GeneroJogos;

use yii\rest\ActiveController;
use common\models\CategoriaJogos;
use common\models\CategoriaRoupa;
use common\models\CategoriaLivros;
use yii\filters\auth\HttpBasicAuth;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaEletronica;
use common\models\CategoriaSmartphones;
use common\models\CategoriaComputadores;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class CategoriasController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];

        return $behaviors;
    }

    public function auth($pin)
    {
    
        $cliente = User::find()
                ->join('JOIN', Cliente::tableName(), User::tableName().'.id = '.Cliente::tableName().'.id_user')
                ->where(['pin' => $pin])
                ->one();

        return $cliente;
    }

    /*public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }*/

    public function actionCriar()
    {
        $dados = Yii::$app->request->post(); 

        $flag = $dados["Categoria"];

        $tier1 = $dados["CategoriaMae"];
        $tier2 = $dados["CategoriaFilha"];
        
        if(isset($dados["CategoriaNeta"])) {
            $tier3 = $dados["CategoriaNeta"];
        }

        //----------
        $base = new Categoria();
        $base->nome = $tier1["nome"];

        if($base->save()) {

            switch ($flag) {

                case 'brinquedos':
                    $categoria = new CategoriaBrinquedos();
                    $categoria->id_categoria = $base->id;
                    $categoria->editora = $tier2['editora'];
                    $categoria->faixa_etaria = $tier2['faixaEtaria'];
                    $categoria->descricao = $tier2['descricao'];

                    if ($categoria->save()) {
                        return ['ID' => $categoria->id_categoria];
                    }

                    break;

                case 'jogos':
                    $categoria = new CategoriaBrinquedos();
                    $categoria->id_categoria = $base->id;
                    $categoria->editora = $tier2['editora'];
                    $categoria->faixa_etaria = $tier2['faixaEtaria'];
                    $categoria->descricao = $tier2['descricao'];

                    if ($categoria->save()) {

                        $subCategoria = new CategoriaJogos();
                        $subCategoria->id_brinquedo = $categoria->id_categoria;
                        $subCategoria->id_genero = $tier3['idGenero'];
                        $subCategoria->produtora = $tier3['produtora'];

                        if ($subCategoria->save()) {
                            return ['ID' => $subCategoria->id_brinquedo];
                        }
                    }

                    break;

                case 'eletronica':
                    $categoria = new CategoriaEletronica();
                    $categoria->id_categoria = $base->id;
                    $categoria->marca = $tier2['marca'];
                    $categoria->descricao = $tier2['descricao'];

                    if($categoria->save()) {
                        return ['ID' => $categoria->id_categoria];
                    }

                    break;

                case 'computadores':
                    $categoria = new CategoriaEletronica();
                    $categoria->id_categoria = $base->id;
                    $categoria->marca = $tier2['marca'];
                    $categoria->descricao = $tier2['descricao'];

                    if ($categoria->save()) {

                        $subCategoria = new CategoriaComputadores();
                        $subCategoria->id_eletronica = $categoria->id_categoria;
                        $subCategoria->processador = $tier3['processador'];
                        $subCategoria->ram = $tier3['ram'];
                        $subCategoria->hdd = $tier3['hdd'];
                        $subCategoria->gpu = $tier3['gpu'];
                        $subCategoria->os = $tier3['os'];
                        $subCategoria->portatil = $tier3['portatil'];

                        if ($subCategoria->save()) {
                            return ['ID' => $subCategoria->id_eletronica];
                        }
                    }

                    break;

                case 'smartphones':
                    $categoria = new CategoriaEletronica();
                    $categoria->id_categoria = $base->id;
                    $categoria->marca = $tier2['marca'];
                    $categoria->descricao = $tier2['descricao'];

                    if($categoria->save()) {

                        $subCategoria = new CategoriaSmartphones();
                        $subCategoria->id_eletronica = $categoria->id_categoria;
                        $subCategoria->processador = $tier3['processador'];
                        $subCategoria->ram = $tier3['ram'];
                        $subCategoria->hdd = $tier3['hdd'];
                        $subCategoria->os = $tier3['os'];
                        $subCategoria->tamanho = $tier3['tamanho'];

                        if ($subCategoria->save()) {
                            return ['ID' => $subCategoria->id_eletronica];
                        }
                    }

                    break;

                case 'roupa':
                    $categoria = new CategoriaRoupa();
                    $categoria->id_categoria = $base->id;
                    $categoria->marca = $tier2['marca'];
                    $categoria->tamanho = $tier2['tamanho'];
                    $categoria->id_tipo = $tier2['idTipo'];

                    if($categoria->save()) {
                        return ['ID' => $categoria->id_categoria];
                    }

                    break;

                case 'livros':
                    $categoria = new CategoriaLivros();
                    $categoria->id_categoria = $base->id;
                    $categoria->titulo = $tier2['titulo'];
                    $categoria->editora = $tier2['editora'];
                    $categoria->autor = $tier2['autor'];
                    $categoria->isbn = $tier2['isbn'];

                    if($categoria->save()) {
                        return ['ID' => $categoria->id_categoria];
                    }

                    break;
            }
        }

        //return ['ID' => $base->id];
        throw new BadRequestHttpException("Não foi possivel inserir as categorias.");
    }

    public function actionGeneros() {

        if(($generos = GeneroJogos::find()->all()) != null) {
            return $generos;
        }

        throw new NotFoundHttpException("Não foram encontrados géneros de jogos.");
    }

    public function actionTipos() {

        if(($tipos = TipoRoupas::find()->all()) != null) {
            return $tipos;
        }

        throw new NotFoundHttpException("Não foram encontrados géneros de jogos.");
    }
}
