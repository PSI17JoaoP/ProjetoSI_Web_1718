<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Anuncio;
use common\models\ImagensAnuncio;
use yii\web\UploadedFile;

/**
 * Anuncio form
 */
class AnuncioForm extends Model
{
    public $titulo;
    public $catOferta;
    public $catProcura;
    public $quantOferta;
    public $quantProcura;
    public $comentarios;

    //Modelos de Oferta e Procura
    public $mOferta;
    public $mProcura;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    //Constantes de Estado do Anúncio
    //const ESTADO_ATIVO = 'ATIVO';
    //const ESTADO_CONCLUIDO = 'CONCLUIDO';
    //const ESTADO_FECHADO = 'FECHADO';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['titulo', 'trim'],
            [['catOferta','titulo','catProcura', 'quantOferta'], 'required'],
            [['quantProcura', 'quantOferta'], 'integer'],
            ['titulo', 'string', 'min' => 2, 'max' => 25],
            [['comentarios'], 'string', 'max' => 256],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => 'upload', 'maxFiles' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'titulo' => 'Título',
            'catOferta' => 'Categoria',
            'catProcura' => 'Categoria',
            'quantOferta' => 'Quantidade',
            'quantProcura' => 'Quantidade',
            'imageFiles' => 'Imagens'
        ];
    }

    public function upload($idAnuncio)
    {
        if ($this->validate()) 
        { 
            foreach ($this->imageFiles as $key => $file) 
            {
                $imgAnuncio = new ImagensAnuncio();
                $imgAnuncio->anuncio_id = $idAnuncio;
                $imgAnuncio->path_relativo = $idAnuncio .'_'. $key . '.' . $file->extension;
                $imgAnuncio->save();

                $file->saveAs('../../common/images/' . $idAnuncio .'_'. $key . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

    public function guardar($idUser, $modeloOferta, $modeloProcura)
    {

        if ($this->validate()) 
        {
            $anuncio = new Anuncio();
            $anuncio->titulo = $this->titulo;
            $anuncio->id_user = $idUser;
            $anuncio->cat_oferecer = $modeloOferta;
            $anuncio->quant_oferecer =$this->quantOferta;
            $anuncio->comentarios = $this->comentarios;
            $anuncio->estado = 'ATIVO';

            if ($modeloProcura !== 'null') {
                $anuncio->cat_receber = $modeloProcura;
                $anuncio->quant_receber = $this->quantProcura;
            }

            $anuncio->data_criacao = date("Y-m-d h:i:s");
            
            $anuncio->save();


            $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');
            
            $uploadStatus = $this->upload($anuncio->id);
            
            if(!$uploadStatus)
            {
                return null;
            }

            return $anuncio;
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
