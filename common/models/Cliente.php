<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $id_user
 * @property string $nome_completo
 * @property string $data_nasc
 * @property integer $telefone
 * @property string $regiao
 * @property integer $pin
 *
 * @property Anuncio[] $anuncios
 * @property User $idUser
 * @property Proposta[] $propostas
 */
class Cliente extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome_completo', 'data_nasc', 'telefone', 'regiao'], 'required'],
            [['telefone', 'pin'], 'integer'],
            [['data_nasc'], 'safe'],
            [['nome_completo'], 'string', 'max' => 50],
            [['regiao'], 'string', 'max' => 10],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome_completo' => 'Nome Completo',
            'data_nasc' => 'Data de Nascimento',
            'telefone' => 'Telefone',
            'regiao' => 'Região',
        ];
    }

    public function updatePIN($pin)
    {
        $this->pin = $pin;

        if($this->save())
        {
            return true;
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncios()
    {
        return $this->hasMany(Anuncio::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropostas()
    {
        return $this->hasMany(Proposta::className(), ['id_user' => 'id_user']);
    }
}
