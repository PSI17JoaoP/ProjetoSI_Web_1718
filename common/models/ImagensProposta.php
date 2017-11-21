<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "imagens_proposta".
 *
 * @property integer $id
 * @property integer $proposta_id
 * @property string $path_relativo
 *
 * @property Proposta $proposta
 */
class ImagensProposta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imagens_proposta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposta_id', 'path_relativo'], 'required'],
            [['proposta_id'], 'integer'],
            [['path_relativo'], 'string', 'max' => 255],
            [['proposta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proposta::className(), 'targetAttribute' => ['proposta_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proposta_id' => 'Proposta ID',
            'path_relativo' => 'Path Relativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProposta()
    {
        return $this->hasOne(Proposta::className(), ['id' => 'proposta_id']);
    }
}
