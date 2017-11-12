<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_jogos".
 *
 * @property integer $id_brinquedo
 * @property integer $id_genero
 * @property string $produtora
 *
 * @property CategoriaBrinquedos $idBrinquedo
 * @property GeneroJogos $idGenero
 */
class CategoriaJogos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_jogos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_brinquedo', 'id_genero', 'produtora'], 'required'],
            [['id_brinquedo', 'id_genero'], 'integer'],
            [['produtora'], 'string', 'max' => 25],
            [['id_brinquedo'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaBrinquedos::className(), 'targetAttribute' => ['id_brinquedo' => 'id_categoria']],
            [['id_genero'], 'exist', 'skipOnError' => true, 'targetClass' => GeneroJogos::className(), 'targetAttribute' => ['id_genero' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_brinquedo' => 'Id Brinquedo',
            'id_genero' => 'Id Genero',
            'produtora' => 'Produtora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBrinquedo()
    {
        return $this->hasOne(CategoriaBrinquedos::className(), ['id_categoria' => 'id_brinquedo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGenero()
    {
        return $this->hasOne(GeneroJogos::className(), ['id' => 'id_genero']);
    }
}
