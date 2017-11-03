<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Anuncios[] $anuncios
 * @property Anuncios[] $anuncios0
 * @property CBrinquedos $cBrinquedos
 * @property CEletronica $cEletronica
 * @property CLivros $cLivros
 * @property CRoupa $cRoupa
 * @property CategoriaPreferida[] $categoriaPreferidas
 * @property User[] $idUsers
 */
class Categoria extends \yii\db\ActiveRecord
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
    public function getAnuncios()
    {
        return $this->hasMany(Anuncios::className(), ['cat_oferecer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncios0()
    {
        return $this->hasMany(Anuncios::className(), ['cat_receber' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCBrinquedos()
    {
        return $this->hasOne(CBrinquedos::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCEletronica()
    {
        return $this->hasOne(CEletronica::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCLivros()
    {
        return $this->hasOne(CLivros::className(), ['id_categoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCRoupa()
    {
        return $this->hasOne(CRoupa::className(), ['id_categoria' => 'id']);
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
