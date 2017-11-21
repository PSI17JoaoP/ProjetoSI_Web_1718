<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "imagens_anuncio".
 *
 * @property integer $id
 * @property integer $anuncio_id
 * @property string $path_relativo
 *
 * @property Anuncio $anuncio
 */
class ImagensAnuncio extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imagens_anuncio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anuncio_id', 'path_relativo'], 'required'],
            [['anuncio_id'], 'integer'],
            [['path_relativo'], 'string', 'max' => 255],
            [['anuncio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Anuncio::className(), 'targetAttribute' => ['anuncio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'anuncio_id' => 'Anuncio ID',
            'path_relativo' => 'Path Relativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncio()
    {
        return $this->hasOne(Anuncio::className(), ['id' => 'anuncio_id']);
    }
}
