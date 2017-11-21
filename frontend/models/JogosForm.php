<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Categoria;
use common\models\CategoriaBrinquedos;
use common\models\CategoriaJogos;
use common\models\GeneroJogos;

/**
 * Anuncio form
 */
class JogosForm extends Model
{
    
    public $nome;
    public $editora;
    public $faixaEtaria;
    public $descricao;
    public $produtora;
    public $generoList;
    public $genero;
    

    public function __construct(){
        $generoJogos = GeneroJogos::find()->all();
        $list = array();

        foreach ($generoJogos as $key => $value) {
            \array_push($list, $value['nome']);
        }
        $this->generoList = $list;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','produtora', 'genero','editora', 'descricao'], 'required'],
            
            ['faixaEtaria', 'integer'],
            [['nome','produtora', 'editora'], 'string', 'max' => 25],
            ['descricao', 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',            
            'produtora' => 'Produtora',
            'genero' => 'Género',
            'descricao' => 'Descrição',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();

            $categoriaBrinq = new CategoriaBrinquedos();
            $categoriaBrinq->id_categoria = $categoriaBase->id;
            $categoriaBrinq->editora = $this->editora;
            $categoriaBrinq->faixa_etaria = $this->faixaEtaria;
            $categoriaBrinq->descricao = $this->descricao;
            $categoriaBrinq->save();
    
            $categoria = new CategoriaJogos();
            $categoria->id_brinquedo = $categoriaBrinq->id_categoria;
            $gen = GeneroJogos::find()
                            ->where(['nome' =>$this->generoList[$this->genero]])
                            ->one();
            $categoria->id_genero = $gen->id;
            $categoria->produtora = $this->produtora;
            $categoria->save();

            return $categoria->id_brinquedo;
        }

        return null;


    }

}
