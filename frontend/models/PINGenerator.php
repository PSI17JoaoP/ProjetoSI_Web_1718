<?php

namespace frontend\models;

use Yii;
use common\models\Cliente;

class PINGenerator
{
    public function generate($length = 15)
    {
        return Yii::$app->getSecurity()->generateRandomString($length);
    }
}