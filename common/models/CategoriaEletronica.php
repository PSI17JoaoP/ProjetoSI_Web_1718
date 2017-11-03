<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_eletronica".
 *
 * @property integer $id_categoria
 * @property string $descricao
 * @property string $marca
 *
 * @property CComputadores $cComputadores
 * @property Categorias $idCategoria
 * @property CSmartphones $cSmartphones
 */
class CategoriaEletronica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_eletronica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria', 'descricao', 'marca'], 'required'],
            [['id_categoria'], 'integer'],
            [['descricao'], 'string', 'max' => 30],
            [['marca'], 'string', 'max' => 25],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['id_categoria' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_categoria' => 'Id Categoria',
            'descricao' => 'Descricao',
            'marca' => 'Marca',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCComputadores()
    {
        return $this->hasOne(CComputadores::className(), ['id_eletronica' => 'id_categoria']);
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
    public function getCSmartphones()
    {
        return $this->hasOne(CSmartphones::className(), ['id_eletronica' => 'id_categoria']);
    }
}
