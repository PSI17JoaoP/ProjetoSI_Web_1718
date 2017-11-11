<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tipo_roupas".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property CategoriaRoupa[] $cRoupas
 */
class TipoRoupas extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_roupas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCRoupas()
    {
        return $this->hasMany(CategoriaRoupa::className(), ['id_tipo' => 'id']);
    }
}
