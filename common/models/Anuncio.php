<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "anuncios".
 *
 * @property integer $id
 * @property string $titulo
 * @property integer $id_user
 * @property integer $cat_oferecer
 * @property integer $quant_oferecer
 * @property integer $cat_receber
 * @property integer $quant_receber
 * @property string $estado
 * @property string $data_criacao
 * @property string $data_conclusao
 * @property string $comentarios
 *
 * @property User $idUser
 * @property Categoria $catOferecer
 * @property Categoria $catReceber
 * @property ImagensAnuncio[] $imagensAnuncios
 * @property Proposta[] $propostas
 */
class Anuncio extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anuncios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'id_user', 'cat_oferecer', 'quant_oferecer', 'estado', 'data_criacao'], 'required'],
            [['id_user', 'cat_oferecer', 'quant_oferecer', 'cat_receber', 'quant_receber'], 'integer'],
            [['data_criacao', 'data_conclusao'], 'safe'],
            [['titulo'], 'string', 'max' => 25],
            [['estado'], 'string', 'max' => 10],
            [['comentarios'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['cat_oferecer'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_oferecer' => 'id']],
            [['cat_receber'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_receber' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'cat_oferecer' => 'Categoria',
            'quant_oferecer' => 'Quantidade',
            'cat_receber' => 'Categoria',
            'quant_receber' => 'Quantidade',
            'comentarios' => 'Comentarios',
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
    public function getCatOferecer()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_oferecer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatReceber()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_receber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagensAnuncios()
    {
        return $this->hasMany(ImagensAnuncio::className(), ['anuncio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropostas()
    {
        return $this->hasMany(Proposta::className(), ['id_anuncio' => 'id']);
    }
}
