<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioBrinquedosForm;
use common\models\GeneroJogos;

/**
 * Anuncio form
 */
class AnuncioJogosForm extends AnuncioBrinquedosForm
{
    
    public $produtora;
    public $generoList;
    public $genero;
    

    public function __construct(){
        $this->generoList = GeneroJogos::find()->all();
    }


    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['produtora', 'genero'], 'required'],
            
            ['produtora', 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'produtora' => 'Produtora',
            'genero' => 'Género',
        ];
    }

}
