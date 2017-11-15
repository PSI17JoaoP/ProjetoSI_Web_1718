<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\materialicons\MD;

?>

<div class="panel panel-primary">
    <div class="panel-body">
        <div class="col-md-4">
            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
        </div>

        <div class="col-md-4" style="text-align: center">
            <?= MD::icon(MD::_SWAP_HORIZ, ['style' => 'font-size: 50px']) ?>
        </div>

        <div class="col-md-4">
            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
        </div>
    </div>
</div>