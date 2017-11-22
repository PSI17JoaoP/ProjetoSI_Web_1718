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
 * @property ImagensProposta[] $imagensPropostas
 * @property User $idUser
 * @property Anuncio $idAnuncio
 * @property Categoria $catProposto
 */
class Proposta extends ActiveRecord
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
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_anuncio'], 'exist', 'skipOnError' => true, 'targetClass' => Anuncio::className(), 'targetAttribute' => ['id_anuncio' => 'id']],
            [['cat_proposto'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_proposto' => 'id']],
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
    public function getImagensPropostas()
    {
        return $this->hasMany(ImagensProposta::className(), ['proposta_id' => 'id']);
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
        return $this->hasOne(Anuncio::className(), ['id' => 'id_anuncio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatProposto()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_proposto']);
    }
}
