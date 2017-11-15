<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Categoria;
use common\models\CategoriaEletronica;

/**
 * Anuncio form
 */
class EletronicaForm extends Model
{
    
    public $nome;
    public $marca;
    public $descricao;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','marca'], 'required'],
            
            [['nome', 'marca'], 'string', 'max' => 25],
            [['descricao'], 'string', 'max' => 30],
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
            'descricao' => 'Descrição',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();
    
            $categoria = new CategoriaEletronica();
            $categoria->id_categoria = $categoriaBase->id;
            $categoria->marca = $this->marca;
            $categoria->descricao = $this->descricao;
            $categoria->save();

            return $categoria->id_categoria;
        }

        return null;
    }

}
