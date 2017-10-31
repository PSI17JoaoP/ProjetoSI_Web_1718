<?php

namespace app\models;

use Yii;

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
 * @property Clientes $idUser
 * @property Categorias $catOferecer
 * @property Categorias $catReceber
 * @property Propostas[] $propostas
 */
class Anuncio extends \yii\db\ActiveRecord
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
            [['comentarios'], 'string', 'max' => 256],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['id_user' => 'id_user']],
            [['cat_oferecer'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['cat_oferecer' => 'id']],
            [['cat_receber'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['cat_receber' => 'id']],
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
            'id_user' => 'Id User',
            'cat_oferecer' => 'Cat Oferecer',
            'quant_oferecer' => 'Quant Oferecer',
            'cat_receber' => 'Cat Receber',
            'quant_receber' => 'Quant Receber',
            'estado' => 'Estado',
            'data_criacao' => 'Data Criacao',
            'data_conclusao' => 'Data Conclusao',
            'comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Clientes::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatOferecer()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'cat_oferecer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatReceber()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'cat_receber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropostas()
    {
        return $this->hasMany(Propostas::className(), ['id_anuncio' => 'id']);
    }
}
