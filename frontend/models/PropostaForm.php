<?php

namespace frontend\models;

use common\models\Proposta;
use common\models\ImagensProposta;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class PropostaForm extends Model
{
    public $catProposto;
    public $quantProposto;
    public $anuncioID;

    //Modelo da categoria do bem a oferecer
    public $modelProposto;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    //Constantes de Estado da Proposta
    //const ESTADO_ACEITE = 'ACEITE';
    //const ESTADO_RECUSADO = 'RECUSADO';
    //const ESTADO_PENDENTE = 'PENDENTE';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catProposto', 'quantProposto', 'anuncioID'], 'required'],
            [['quantProposto', 'anuncioID'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => 'upload', 'maxFiles' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'catProposto' => 'Categoria',
            'quantProposto' => 'Quantidade',
            'imageFiles' => 'Imagens'
        ];
    }

    public function upload($idAnuncio, $idProposta)
    {
        if ($this->validate()) 
        { 
            foreach ($this->imageFiles as $key => $file) 
            {
                $imgAnuncio = new ImagensProposta();
                $imgAnuncio->proposta_id = $idProposta;
                $imgAnuncio->path_relativo = $idProposta .'_'. $key . '.' . $file->extension;
                $imgAnuncio->save();

                $file->saveAs('../../common/images/' . $idAnuncio .'_' . $idProposta .'_'. $key . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

    public function enviar($categoriaPropostoID)
    {
        if ($this->validate())
        {
            $proposta = new Proposta();

            $proposta->id_user = Yii::$app->user->getId();
            $proposta->cat_proposto = $categoriaPropostoID;
            $proposta->quant = $this->quantProposto;
            $proposta->estado = 'PENDENTE';
            $proposta->id_anuncio = $this->anuncioID;
            $proposta->data_proposta = date("Y-m-d h:i:s");

            $proposta->save();


            $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');
            
            $uploadStatus = $this->upload($this->anuncioID, $proposta->id);
            
            if(!$uploadStatus)
            {
                return null;
            }

            return $proposta;
        }

        return null;
    }

    /**
     *
     *
     * @param $categoria
     * @return mixed
     */
    public function selecionarCategoria($categoria)
    {
        $model = null;

        switch ($categoria) {
            case 'brinquedos':
                $model = new BrinquedosForm();
                break;
            case 'jogos':
                $model = new JogosForm();
                break;
            case 'eletronica':
                $model = new EletronicaForm();
                break;
            case 'computadores':
                $model = new ComputadoresForm();
                break;
            case 'smartphones':
                $model = new SmartphonesForm();
                break;
            case 'livros':
                $model = new LivrosForm();
                break;
            case 'roupa':
                $model = new RoupaForm();
                break;
            case 'todos':
                $model = new TodosForm();

        }

        return $model;
    }
}