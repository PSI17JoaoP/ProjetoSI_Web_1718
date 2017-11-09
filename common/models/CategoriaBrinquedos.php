<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_brinquedos".
 *
 * @property integer $id_categoria
 * @property string $editora
 * @property integer $faixa_etaria
 * @property string $descricao
 *
 * @property Categorias $idCategoria
 * @property CJogos $cJogos
 */
class CategoriaBrinquedos extends \yii\db\ActiveRecord
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
            'id_categoria' => 'Id Categoria',
            'editora' => 'Editora',
            'faixa_etaria' => 'Faixa Etaria',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCJogos()
    {
        return $this->hasOne(CJogos::className(), ['id_brinquedo' => 'id_categoria']);
    }
}
