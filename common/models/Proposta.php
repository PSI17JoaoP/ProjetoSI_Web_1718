<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "propostas".
 *
 * @property integer $id
 * @property integer $cat_proposto
 * @property integer $quant
 * @property integer $id_user
 * @property integer $id_anuncio
 * @property string $estado
 * @property string $data_proposta
 *
 * @property ImagensProposta[] $imagensPropostas
 * @property User $idUser
 * @property Anuncio $idAnuncio
 * @property Categoria $catProposto
 */
class Proposta extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propostas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_proposto', 'quant', 'id_user', 'id_anuncio', 'estado', 'data_proposta'], 'required'],
            [['cat_proposto', 'quant', 'id_user', 'id_anuncio'], 'integer'],
            [['data_proposta'], 'safe'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_anuncio'], 'exist', 'skipOnError' => true, 'targetClass' => Anuncio::className(), 'targetAttribute' => ['id_anuncio' => 'id']],
            [['cat_proposto'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_proposto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_proposto' => 'Categoria',
            'quant' => 'Quantidade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagensPropostas()
    {
        return $this->hasMany(ImagensProposta::className(), ['proposta_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAnuncio()
    {
        return $this->hasOne(Anuncio::className(), ['id' => 'id_anuncio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatProposto()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_proposto']);
    }


    //-----------------------------------------------------
    //                      MOSQUITTO
    //-----------------------------------------------------

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $objeto=new \stdClass();

        $objeto->id = $this->id;
        $objeto->cat_proposto = $this->cat_proposto;
        $objeto->quant = $this->quant;
        $objeto->id_user = $this->id_user;
        $objeto->id_anuncio = $this->id_anuncio;
        $objeto->estado = $this->estado;
        $objeto->data_proposta = $this->data_proposta;

        $objJSON= json_encode($objeto);

        if($insert)
            $this->Publicar("InsertProposta",$objJSON);
        else
            $this->Publicar("UpdateProposta",$objJSON);
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
