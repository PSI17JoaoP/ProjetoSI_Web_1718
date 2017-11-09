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
    public $type;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['titulo', 'trim'],
            ['titulo', 'required'],
            ['titulo', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'titulo' => 'Título',
            'type' => 'Categoria',
        ];
    }

}
