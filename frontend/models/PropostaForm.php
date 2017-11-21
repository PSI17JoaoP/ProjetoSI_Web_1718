<?php

namespace frontend\models;

use common\models\Proposta;
use Yii;
use yii\base\Model;

class PropostaForm extends Model
{
    public $catProposto;
    public $quantProposto;
    public $anuncioID;

    //Modelo da categoria do bem a oferecer
    public $modelProposto;

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
        ];
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