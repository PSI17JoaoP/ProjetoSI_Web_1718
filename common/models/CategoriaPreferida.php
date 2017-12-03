<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria_preferida".
 *
 * @property integer $id_user
 * @property string $categoria
 *
 * @property User $idUser
 */
class CategoriaPreferida extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria_preferida';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'categoria'], 'required'],
            [['id_user'], 'integer'],
            [['categoria'], 'string', 'max' => 15],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
