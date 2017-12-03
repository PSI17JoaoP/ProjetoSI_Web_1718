<?php

namespace frontend\models;

use common\models\Cliente;
use common\models\CategoriaPreferida;
use yii\base\Model;

class ClienteForm extends Model
{
    public $nomeCompleto;
    public $dataNasc;
    public $telefone;
    public $regiao;

    public $catPref = array();

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomeCompleto', 'dataNasc', 'telefone', 'regiao'], 'required'],
            ['regiao', 'string', 'max' => 10],
            ['nomeCompleto', 'string', 'max' => 50],
            [['telefone'], 'integer', 'min' => 910000000, 'max' => 990000000],
            ['catPref', 'each', 'rule' => ['string']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nomeCompleto' => 'Nome Completo',
            'telefone' => 'Nº Telef./Telemóvel',
            'regiao' => 'Região',
            'dataNasc' => 'Data de Nascimento',
            'catPref' => 'Categorias Preferidas'
        ];
    }

    public function carregar($cliente)
    {
        $this->nomeCompleto = $cliente->nome_completo;
        $this->dataNasc = $cliente->data_nasc;
        $this->telefone = $cliente->telefone;
        $this->regiao = $cliente->regiao;

        foreach ($cliente->user->categoriasPreferidas as $key => $value) {
            \array_push($this->catPref, $value->categoria);
        }
    }

    public function guardar($userID) {

        if ($this->validate()) {

            $cliente = new Cliente();
            $cliente->nome_completo = $this->nomeCompleto;
            $cliente->data_nasc = $this->dataNasc;
            $cliente->telefone = $this->telefone;
            $cliente->regiao = $this->regiao;
            $cliente->id_user = $userID;

            $cliente->save();

            return $cliente;
        }

        return null;
    }

    public function atualizar($cliente) {

        //static
        $this->dataNasc = $cliente->data_nasc;
        
        if ($this->validate()) {

            $cliente->nome_completo = $this->nomeCompleto;
            $cliente->data_nasc = $this->dataNasc;
            $cliente->telefone = $this->telefone;
            $cliente->regiao = $this->regiao;
            
            $cliente->save(false);

            CategoriaPreferida::deleteAll("id_user = $cliente->id_user");

            foreach ($this->catPref as $key => $value) {
                $catP = new CategoriaPreferida();
                $catP->id_user = $cliente->id_user;
                $catP->categoria = $value;

                $catP->save();
            }

            return $cliente;
        }

        return null;
    }
}