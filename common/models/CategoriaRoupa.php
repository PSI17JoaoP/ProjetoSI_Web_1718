<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_roupa".
 *
 * @property integer $id_categoria
 * @property string $marca
 * @property string $tamanho
 * @property integer $id_tipo
 *
 * @property Categoria $idCategoria
 * @property TipoRoupas $idTipo
 */
class CategoriaRoupa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_roupa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria', 'marca', 'tamanho', 'id_tipo'], 'required'],
            [['id_categoria', 'id_tipo'], 'integer'],
            [['marca'], 'string', 'max' => 25],
            [['tamanho'], 'string', 'max' => 5],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id']],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoRoupas::className(), 'targetAttribute' => ['id_tipo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoria' => 'Id Categoria',
            'marca' => 'Marca',
            'tamanho' => 'Tamanho',
            'id_tipo' => 'Id Tipo',
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
    public function getIdTipo()
    {
        return $this->hasOne(TipoRoupas::className(), ['id' => 'id_tipo']);
    }
}
