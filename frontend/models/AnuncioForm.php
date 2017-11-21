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
    public $comentarios;

    //Modelos de Oferta e Procura
    public $mOferta;
    public $mProcura;

    //Constantes de Estado do Anúncio
    //const ESTADO_ATIVO = 'ATIVO';
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
            $anuncio->comentarios = $this->comentarios;
            $anuncio->estado = 'ATIVO';

            if ($modeloProcura !== 'null') {
                $anuncio->cat_receber = $modeloProcura;
                $anuncio->quant_receber = $this->quantProcura;
            }

            $anuncio->data_criacao = date("Y-m-d h:i:s");
            $anuncio->save();

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