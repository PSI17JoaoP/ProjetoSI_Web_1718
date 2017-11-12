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
            [['catOferta','titulo','catProcura'], 'required'],
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
            $anuncio->quant_oferecer = 1;
            $anuncio->cat_receber = $modeloProcura;
            $anuncio->quant_receber = 1;
            $anuncio->estado = 'ativo';
            $anuncio->data_criacao = date("Y-m-d h:i:s");
            $anuncio->comentarios = $this->comentarios;
            $anuncio->save();

            return $anuncio;
        }

        return null;
    }

}
