<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "anuncios".
 *
 * @property integer $id
 * @property string $titulo
 * @property integer $id_user
 * @property integer $cat_oferecer
 * @property integer $quant_oferecer
 * @property integer $cat_receber
 * @property integer $quant_receber
 * @property string $estado
 * @property string $data_criacao
 * @property string $data_conclusao
 * @property string $comentarios
 *
 * @property User $idUser
 * @property Categoria $catOferecer
 * @property Categoria $catReceber
 * @property ImagensAnuncio[] $imagensAnuncios
 * @property Proposta[] $propostas
 */
class Anuncio extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anuncios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'id_user', 'cat_oferecer', 'quant_oferecer', 'estado', 'data_criacao'], 'required'],
            [['id_user', 'cat_oferecer', 'quant_oferecer', 'cat_receber', 'quant_receber'], 'integer'],
            [['data_criacao', 'data_conclusao'], 'safe'],
            [['titulo'], 'string', 'max' => 25],
            [['estado'], 'string', 'max' => 10],
            [['comentarios'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['cat_oferecer'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_oferecer' => 'id']],
            [['cat_receber'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['cat_receber' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'cat_oferecer' => 'Categoria',
            'quant_oferecer' => 'Quantidade',
            'cat_receber' => 'Categoria',
            'quant_receber' => 'Quantidade',
            'comentarios' => 'Comentarios',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatOferecer()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_oferecer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatReceber()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'cat_receber']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagensAnuncios()
    {
        return $this->hasMany(ImagensAnuncio::className(), ['anuncio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropostas()
    {
        return $this->hasMany(Proposta::className(), ['id_anuncio' => 'id']);
    }


    //-----------------------------------------------------
    //                      MOSQUITTO
    //-----------------------------------------------------

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $objeto=new \stdClass();

        $objeto->id = $this->id;
        $objeto->titulo = $this->titulo;
        $objeto->id_user = $this->id_user;
        $objeto->cat_oferecer = $this->cat_oferecer;
        $objeto->quant_oferecer = $this->quant_oferecer;
        $objeto->cat_receber = $this->cat_receber;
        $objeto->quant_receber = $this->quant_receber;
        $objeto->estado = $this->estado;
        $objeto->data_criacao = $this->data_criacao;
        $objeto->data_conclusao = $this->data_conclusao;
        $objeto->comentarios = $this->comentarios;


        $objJSON= json_encode($objeto);

        if($insert)
            $this->Publicar("InsertAnuncio",$objJSON);
        else
            $this->Publicar("UpdateAnuncio",$objJSON);
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
