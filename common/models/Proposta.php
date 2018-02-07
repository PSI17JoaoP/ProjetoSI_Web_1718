<?php

namespace common\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use common\models\Anuncio;
use common\models\Notificacoes;

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

        /*$objeto=new \stdClass();

        $objeto->id = $this->id;
        $objeto->cat_proposto = $this->cat_proposto;
        $objeto->quant = $this->quant;
        $objeto->id_user = $this->id_user;
        $objeto->id_anuncio = $this->id_anuncio;
        $objeto->estado = $this->estado;
        $objeto->data_proposta = $this->data_proposta;

        $objJSON= json_encode($objeto);
        
        if($insert)
        {
            $this->Publicar("InsertProposta",$objJSON);
        }
        else
        {
            $this->Publicar("UpdateProposta",$objJSON);
        }*/
           
        
        $usernameCliente = "";
        $mensagem = "";
        $idCliente = 0;

        if ($this->estado == "PENDENTE") //Notificar cliente de proposta recebida
        {
            $anuncio = Anuncio::findOne(["id" => $this->id_anuncio]);
            $usernameCliente = $anuncio->idUser->username;
            $titulo = $anuncio->titulo;
            $mensagem = "Nova proposta para o seu anúncio '$titulo";
            $idCliente = $anuncio->idUser->id;
        }else //Notificar cliente de estado da proposta (aceite/recusar)
        {
            if ($this->estado == "ACEITE") {
                $estado = "aceite!";
            } else {
                $estado = "recusada.";
            }
            

            $usernameCliente = User::findOne(["id" => $this->id_user])->username;
            $titulo = Anuncio::findOne(["id" => $this->id_anuncio])->titulo;
            $mensagem = "A sua proposta ao anúncio '$titulo' foi $estado";
            $idCliente = $this->id_user;
        }

        //$this->Publicar($usernameCliente, $mensagem);

        //Tabela
        $notificacao = new Notificacoes();
        $notificacao->id_user = $idCliente;
        $notificacao->mensagem = $mensagem;
        $notificacao->lida = 0;
        $notificacao->save();

    }

    /*public function Publicar($canal,$msg)
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
    }*/
}
