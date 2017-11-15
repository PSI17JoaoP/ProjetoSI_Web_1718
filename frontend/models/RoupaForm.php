<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Categoria;
use common\models\CategoriaRoupa;
use common\models\TipoRoupas;

/**
 * Anuncio form
 */
class RoupaForm extends Model
{
    
    public $nome;
    public $marca;
    public $tamanho;
    public $tipoRoupaList;
    public $tipoRoupa;


    public function __construct(){
        $tipoRoupas = TipoRoupas::find()->all();
        $list = array();

        foreach ($tipoRoupas as $key => $value) {
            \array_push($list, $value['nome']);
        }
        $this->tipoRoupaList = $list;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','marca', 'tamanho', 'tipoRoupa'], 'required'],
            
            [['nome', 'marca'], 'string', 'max' => 25],
            [['tamanho'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'marca' => 'Marca',
            'tamanho' => 'Tamanho',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();
    
            $categoria = new CategoriaRoupa();
            $categoria->id_categoria = $categoriaBase->id;
            $categoria->marca = $this->marca;
            $categoria->tamanho = $this->tamanho;
            $tipo = TipoRoupas::find()
                        ->where(['nome' => $this->tipoRoupaList[$this->tipoRoupa]])
                        ->one();
            $categoria->id_tipo = $tipo->id;
            $categoria->save();

            return $categoria->id_categoria;
        }

        return null;
    }

}
