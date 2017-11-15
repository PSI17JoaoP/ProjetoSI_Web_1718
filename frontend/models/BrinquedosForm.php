<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Categoria;
use common\models\CategoriaBrinquedos;

/**
 * Anuncio form
 */
class BrinquedosForm extends Model
{
    
    public $nome;
    public $editora;
    public $faixaEtaria;
    public $descricao;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','editora', 'descricao'], 'required'],
            
            ['faixaEtaria', 'integer'],
            [['nome', 'editora'], 'string', 'max' => 25],
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
            'editora' => 'Editora',
            'descricao' => 'Descrição',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();
    
            $categoria = new CategoriaBrinquedos();
            $categoria->id_categoria = $categoriaBase->id;
            $categoria->editora = $this->editora;
            $categoria->faixa_etaria = $this->faixaEtaria;
            $categoria->descricao = $this->descricao;
            $categoria->save();

            return $categoria->id_categoria;
        }

        return null;
    }

}
