<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "genero_jogos".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property CategoriaJogos[] $cJogos
 */
class GeneroJogos extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genero_jogos';
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
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCJogos()
    {
        return $this->hasMany(CategoriaJogos::className(), ['id_genero' => 'id']);
    }
}
