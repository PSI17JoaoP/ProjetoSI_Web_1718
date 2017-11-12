<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "c_computadores".
 *
 * @property integer $id_eletronica
 * @property string $processador
 * @property string $ram
 * @property string $hdd
 * @property string $gpu
 * @property string $os
 * @property integer $portatil
 *
 * @property CategoriaEletronica $idEletronica
 */
class CategoriaComputadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_computadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_eletronica', 'processador', 'ram', 'hdd', 'gpu', 'os'], 'required'],
            [['id_eletronica', 'portatil'], 'integer'],
            [['processador', 'gpu'], 'string', 'max' => 50],
            [['ram'], 'string', 'max' => 5],
            [['hdd'], 'string', 'max' => 10],
            [['os'], 'string', 'max' => 25],
            [['id_eletronica'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaEletronica::className(), 'targetAttribute' => ['id_eletronica' => 'id_categoria']],
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
            'gpu' => 'Gpu',
            'os' => 'Os',
            'portatil' => 'Portatil',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEletronica()
    {
        return $this->hasOne(CategoriaEletronica::className(), ['id_categoria' => 'id_eletronica']);
    }
}
