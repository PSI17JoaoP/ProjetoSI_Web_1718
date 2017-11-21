<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "c_eletronica".
 *
 * @property integer $id_categoria
 * @property string $descricao
 * @property string $marca
 *
 * @property CategoriaComputadores $cComputadores
 * @property Categoria $idCategoria
 * @property CategoriaSmartphones $cSmartphones
 */
class CategoriaEletronica extends ActiveRecord
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
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'descricao' => 'Descrição',
            'marca' => 'Marca',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCComputadores()
    {
        return $this->hasOne(CategoriaComputadores::className(), ['id_eletronica' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCSmartphones()
    {
        return $this->hasOne(CategoriaSmartphones::className(), ['id_eletronica' => 'id_categoria']);
    }
}
