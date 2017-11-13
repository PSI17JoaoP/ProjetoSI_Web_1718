<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioForm;
use common\models\Categoria;
use common\models\CategoriaLivros;

/**
 * Anuncio form
 */
class AnuncioLivrosForm extends Model
{
    
    public $nome;
    public $titulo;
    public $editora;
    public $autor;
    public $isbn;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome','titulo', 'editora', 'autor', 'isbn'], 'required'],
            
            ['isbn', 'integer'],
            [['nome', 'editora'], 'string', 'max' => 25],
            [['titulo'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'titulo' => 'Título',
            'editora' => 'Editora',
            'autor' => 'Autor',
            'isbn' => 'ISBN',
        ];
    }

    public function guardar()
    {
        if ($this->validate()) {
            $categoriaBase = new Categoria();
            $categoriaBase->nome = $this->nome;
            $categoriaBase->save();
    
            $categoria = new CategoriaLivros();
            $categoria->id_categoria = $categoriaBase->id;
            $categoria->titulo = $this->titulo;
            $categoria->editora = $this->editora;
            $categoria->autor = $this->autor;
            $categoria->save();

            return $categoria->id_categoria;
        }

        return null;
    }

}
