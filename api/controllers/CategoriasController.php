<?php

namespace api\controllers;

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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionCriar()
    {
        $dados = Yii::$app->request->post(); 

        $flag = $dados["Categoria"];

        $tier1 = $dados["CategoriaMae"];
        $tier2 = $dados["CategoriaFilha"];
        
        if(isset($dados["CategoriaNeta"]))
        {
            $tier3 = $dados["CategoriaNeta"];
        }
        //----------
        $base = new Categoria();
        $base->nome = $tier1["nome"];
        $base->save();

        switch ($flag) 
        {
            case 'brinquedo':
                $categoria = new CategoriaBrinquedos();
                $categoria->id_categoria = $base->id;
                $categoria->editora = $tier2['editora'];
                $categoria->faixa_etaria = $tier2['faixaEtaria'];
                $categoria->descricao = $tier2['descricao'];
                $categoria->save();

                break;
            
                case 'jogos':
                $categoria = new CategoriaBrinquedos();
                $categoria->id_categoria = $base->id;
                $categoria->editora = $tier2['editora'];
                $categoria->faixa_etaria = $tier2['faixaEtaria'];
                $categoria->descricao = $tier2['descricao'];
                $categoria->save();

                $subCategoria = new CategoriaJogos();
                $subCategoria->id_brinquedo = $categoria->id_categoria;
                $subCategoria->id_genero = $tier3['idGenero'];
                $subCategoria->produtora = $tier3['produtora'];
                $subCategoria->save();
                break;

            case 'eletronica':
                $categoria = new CategoriaEletronica();
                $categoria->id_categoria = $base->id;
                $categoria->marca = $tier2['marca'];
                $categoria->descricao = $tier2['descricao'];
                $categoria->save();
                break;
            
            case 'computadores':
                $categoria = new CategoriaEletronica();
                $categoria->id_categoria = $base->id;
                $categoria->marca = $tier2['marca'];
                $categoria->descricao = $tier2['descricao'];
                $categoria->save();

                $subCategoria = new CategoriaComputadores();
                $subCategoria->id_eletronica = $categoria->id_categoria;
                $subCategoria->processador = $tier3['processador'];
                $subCategoria->ram = $tier3['ram'];
                $subCategoria->hdd = $tier3['hdd'];
                $subCategoria->gpu = $tier3['gpu'];
                $subCategoria->os = $tier3['os'];
                $subCategoria->portatil = $tier3['portatil'];
                $subCategoria->save();
                break;

            case 'smartphones':
                $categoria = new CategoriaEletronica();
                $categoria->id_categoria = $base->id;
                $categoria->marca = $tier2['marca'];
                $categoria->descricao = $tier2['descricao'];
                $categoria->save();

                $subCategoria = new CategoriaSmartphones();
                $subCategoria->id_eletronica = $categoria->id_categoria;
                $subCategoria->processador = $tier3['processador'];
                $subCategoria->ram = $tier3['ram'];
                $subCategoria->hdd = $tier3['hdd'];
                $subCategoria->os = $tier3['os'];
                $subCategoria->tamanho = $tier3['tamanho'];
                $subCategoria->save();
                break;

            case 'roupa':
                $categoria = new CategoriaRoupa();
                $categoria->id_categoria = $base->id;
                $categoria->marca = $tier2['marca'];
                $categoria->tamanho = $tier2['tamanho'];
                $categoria->id_tipo = $tier2['idTipo'];
                $categoria->save();
                break;

            case 'livros':
                $categoria = new CategoriaLivros();
                $categoria->id_categoria = $base->id;
                $categoria->titulo = $tier2['titulo'];
                $categoria->editora = $tier2['editora'];
                $categoria->autor = $tier2['autor'];
                $categoria->isbn = $tier2['isbn'];
                $categoria->save();
                break;
        }

        return ['ID' => $base->id];
    }

    public function actionApagar($id)
    {
        $base = Categoria::findOne(['id' => $id]);

        if($base == null)
        {
            return new NotFoundHttpException('Não foi encontrada a categoria desejada.', 404);
        }

        if($base)
        {
            if ($base->cRoupa) {
                CategoriaRoupa::deleteAll('id_categoria='.$id);
            }

            if ($base->cLivros) {
                CategoriaLivros::deleteAll('id_categoria='.$id);
            }

            if ($base->cEletronica) {
                if ($base->cEletronica->cComputadores) {
                    CategoriaComputadores::deleteAll('id_eletronica='.$id);
                }else if ($base->cEletronica->cSmartphones) {
                    CategoriaSmartphones::deleteAll('id_eletronica='.$id);
                }
                CategoriaEletronica::deleteAll('id_categoria='.$id);
            }

            if ($base->cBrinquedos) {
                if ($base->cBrinquedos->cJogos) {
                    CategoriaJogos::deleteAll('id_brinquedo='.$id);
                }
                CategoriaBrinquedos::deleteAll('id_categoria='.$id);
            }

            Categoria::deleteAll('id='.$id);
        }

        return $id;
    }
}
