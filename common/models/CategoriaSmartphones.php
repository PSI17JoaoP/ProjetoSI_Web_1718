<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_smartphones".
 *
 * @property integer $id_eletronica
 * @property string $processador
 * @property string $ram
 * @property string $hdd
 * @property string $os
 * @property string $tamanho
 *
 * @property CEletronica $idEletronica
 */
class CategoriaSmartphones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_smartphones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_eletronica', 'processador', 'ram', 'hdd', 'os'], 'required'],
            [['id_eletronica'], 'integer'],
            [['processador'], 'string', 'max' => 50],
            [['ram'], 'string', 'max' => 5],
            [['hdd', 'tamanho'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 25],
            [['id_eletronica'], 'exist', 'skipOnError' => true, 'targetClass' => CEletronica::className(), 'targetAttribute' => ['id_eletronica' => 'id_categoria']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_eletronica' => 'Id Eletronica',
            'processador' => 'Processador',
            'ram' => 'Ram',
            'hdd' => 'Hdd',
            'os' => 'Os',
            'tamanho' => 'Tamanho',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEletronica()
    {
        return $this->hasOne(CEletronica::className(), ['id_categoria' => 'id_eletronica']);
    }
}
