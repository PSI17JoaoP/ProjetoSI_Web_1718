<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_livros".
 *
 * @property integer $id_categoria
 * @property string $titulo
 * @property string $editora
 * @property string $autor
 * @property integer $isbn
 *
 * @property Categorias $idCategoria
 */
class CategoriaLivros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_livros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria', 'titulo', 'editora', 'autor', 'isbn'], 'required'],
            [['id_categoria', 'isbn'], 'integer'],
            [['titulo'], 'string', 'max' => 30],
            [['editora', 'autor'], 'string', 'max' => 25],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['id_categoria' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoria' => 'Id Categoria',
            'titulo' => 'Titulo',
            'editora' => 'Editora',
            'autor' => 'Autor',
            'isbn' => 'Isbn',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'id_categoria']);
    }
}
