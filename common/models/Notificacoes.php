<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notificacoes".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $mensagem
 * @property integer $lida
 *
 * @property User $idUser
 */
class Notificacoes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notificacoes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'mensagem'], 'required'],
            [['id_user', 'lida'], 'integer'],
            [['mensagem'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'mensagem' => 'Mensagem',
            'lida' => 'Lida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function ler()
    {
        $this->lida = 1;
        return $this->save();
    }
}
