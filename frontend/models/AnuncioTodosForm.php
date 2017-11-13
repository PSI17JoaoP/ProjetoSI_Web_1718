<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\AnuncioForm;


/**
 * Anuncio form
 */
class AnuncioTodosForm extends Model
{
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }

    public function guardar()
    {
        return 'null';
    }

}
