<?php

namespace frontend\models;

use common\models\Cliente;
use yii\base\Model;

class ClienteForm extends Model
{
    public $nomeCompleto;
    public $dataNasc;
    public $telefone;
    public $regiao;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomeCompleto', 'dataNasc', 'telefone', 'regiao'], 'required'],
            ['regiao', 'string', 'max' => 10],
            ['nomeCompleto', 'string', 'max' => 50],
            [['telefone'], 'integer', 'min' => 9, 'max' => 9],
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
            'dataNasc' => 'Data de Nascimento'
        ];
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
}