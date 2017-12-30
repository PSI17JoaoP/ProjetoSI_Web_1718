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
 * @property string $pin
 * @property string $path_imagem 
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
            [['telefone'], 'integer'],
            [['data_nasc'], 'safe'],
            [['nome_completo'], 'string', 'max' => 50],
            [['pin'], 'string', 'max' => 5],
            [['regiao'], 'string', 'max' => 10],
            [['path_imagem'], 'string', 'max' => 255],
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
            'pin' => 'Pin',
            'path_imagem' => 'Imagem',
        ];
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


    //-----------------------------------------------------
    //                      MOSQUITTO
    //-----------------------------------------------------

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $objeto=new \stdClass();

        $objeto->id_user = $this->id_user;
        $objeto->nome_completo = $this->nome_completo;
        $objeto->data_nasc = $this->data_nasc;
        $objeto->telefone = $objeto->telefone;
        $objeto->regiao = $this->regiao;
        $objeto->pin = $this->pin;
        $objeto->path_imagem = $this->path_imagem;

        $objJSON= json_encode($objeto);

        if($insert)
            $this->Publicar("InsertCliente",$objJSON);
        else
            $this->Publicar("UpdateCliente",$objJSON);
    }

    public function Publicar($canal,$msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = ""; // set your username
        $password = ""; // set your password
        $client_id= "APIServer-publisher"; // unique!
        $mqtt= new \common\mosquitto\phpMQTT($server, $port, $client_id);
       
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }else 
        { 
            file_put_contents("debug.output","Timeout!"); 
        }
    }
}
