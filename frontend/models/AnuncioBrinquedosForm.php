<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioForm;

/**
 * Anuncio form
 */
class AnuncioBrinquedosForm extends AnuncioForm
{
    
    public $editora;
    public $descricao;

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
