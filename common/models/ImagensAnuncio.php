<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "imagens_anuncio".
 *
 * @property integer $anuncio_id
 * @property string $path_relativo
 */
class ImagensAnuncio extends \yii\db\ActiveRecord
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
            [['path_relativo'], 'required'],
            [['path_relativo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'anuncio_id' => 'Anuncio ID',
            'path_relativo' => 'Path Relativo',
        ];
    }
}
