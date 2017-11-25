<?php
namespace frontend\models;

use Yii;
use yii\base\Model;


/**
 * Anuncio form
 */
class TodosForm extends Model
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
