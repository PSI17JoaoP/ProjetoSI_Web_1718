<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Anuncio;

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
    //incluir modelos neste
    public $mOferta;
    public $mProcura;
    //--
    public $comentarios;

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
        ];
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
            if ($modeloProcura!='null') {
                $anuncio->cat_receber = $modeloProcura;
                $anuncio->quant_receber = $this->quantProcura;
            }
            $anuncio->estado = 'ativo';
            $anuncio->data_criacao = date("Y-m-d h:i:s");
            $anuncio->comentarios = $this->comentarios;
            $anuncio->save();

            return $anuncio;
        }

        return null;
    }

}
