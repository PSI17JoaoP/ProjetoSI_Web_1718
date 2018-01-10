<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "c_brinquedos".
 *
 * @property integer $id_categoria
 * @property string $editora
 * @property integer $faixa_etaria
 * @property string $descricao
 *
 * @property Categoria $idCategoria
 * @property CategoriaJogos $cJogos
 */
class CategoriaBrinquedos extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_brinquedos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria', 'editora', 'descricao'], 'required'],
            [['id_categoria', 'faixa_etaria'], 'integer'],
            [['editora'], 'string', 'max' => 25],
            [['descricao'], 'string', 'max' => 30],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoria' => 'Categoria',
            'editora' => 'Editora',
            'faixa_etaria' => 'Faixa Etária',
            'descricao' => 'Descrição',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCJogos()
    {
        return $this->hasOne(CategoriaJogos::className(), ['id_brinquedo' => 'id_categoria']);
    }
}
