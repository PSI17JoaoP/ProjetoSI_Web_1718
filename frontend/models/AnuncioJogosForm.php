<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioBrinquedosForm;

/**
 * Anuncio form
 */
class AnuncioJogosForm extends AnuncioBrinquedosForm
{
    
    public $produtora;
    public $genero;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['editora', 'descricao'], 'required'],
            
            ['editora', 'string', 'max' => 25],

            ['descricao', 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'editora' => 'Editora',
            'descricao' => 'Descrição',
        ];
    }

}
