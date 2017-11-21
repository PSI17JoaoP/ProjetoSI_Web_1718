<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categorias".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Anuncio[] $anuncios
 * @property Anuncio[] $anuncios0
 * @property CategoriaBrinquedos $cBrinquedos
 * @property CategoriaEletronica $cEletronica
 * @property CategoriaLivros $cLivros
 * @property CategoriaRoupa $cRoupa
 * @property CategoriaPreferida[] $categoriaPreferidas
 * @property User[] $idUsers
 */
class Categoria extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorias';
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
    public function getAnunciosBemOferecer()
    {
        return $this->hasMany(Anuncio::className(), ['cat_oferecer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnunciosBemReceber()
    {
        return $this->hasMany(Anuncio::className(), ['cat_receber' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCBrinquedos()
    {
        return $this->hasOne(CategoriaBrinquedos::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCEletronica()
    {
        return $this->hasOne(CategoriaEletronica::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCLivros()
    {
        return $this->hasOne(CategoriaLivros::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCRoupa()
    {
        return $this->hasOne(CategoriaRoupa::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaPreferidas()
    {
        return $this->hasMany(CategoriaPreferida::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'id_user'])->viaTable('categoria_preferida', ['id_categoria' => 'id']);
    }
}
