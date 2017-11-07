<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

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
class Proposta extends ActiveRecord
{
    const ESTADO_ABERTA = 'ABERTA';
    const ESTADO_ACEITE = 'ACEITE';
    const ESTADO_RECUSADA = 'RECUSADA';

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
            ['estado', 'default', 'value' => self::ESTADO_ABERTA],
            ['status', 'in', 'range' => [self::ESTADO_ACEITE, self::ESTADO_RECUSADA, self::ESTADO_ABERTA]],
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
            'cat_proposto' => 'Categoria',
            'quant' => 'Quantidade',
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
