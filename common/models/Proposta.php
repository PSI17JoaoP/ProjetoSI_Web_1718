<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "propostas".
 *
 * @property integer $id
 * @property integer $cat_proposto
 * @property integer $quant
 * @property integer $id_user
 * @property integer $id_anuncio
 * @property string $estado
 * @property string $data_proposta
 *
 * @property User $idUser
 * @property Anuncio $idAnuncio
 */
class Proposta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propostas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_proposto', 'quant', 'id_user', 'id_anuncio', 'estado', 'data_proposta'], 'required'],
            [['cat_proposto', 'quant', 'id_user', 'id_anuncio'], 'integer'],
            [['data_proposta'], 'safe'],
            [['estado'], 'string', 'max' => 10],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id_user']],
            [['id_anuncio'], 'exist', 'skipOnError' => true, 'targetClass' => Anuncio::className(), 'targetAttribute' => ['id_anuncio' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_proposto' => 'Cat Proposto',
            'quant' => 'Quant',
            'id_user' => 'Id User',
            'id_anuncio' => 'Id Anuncio',
            'estado' => 'Estado',
            'data_proposta' => 'Data Proposta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAnuncio()
    {
        return $this->hasOne(User::className(), ['id' => 'id_anuncio']);
    }
}
