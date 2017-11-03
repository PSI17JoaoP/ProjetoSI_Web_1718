<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AnuncioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anuncio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'cat_oferecer') ?>

    <?= $form->field($model, 'quant_oferecer') ?>

    <?php // echo $form->field($model, 'cat_receber') ?>

    <?php // echo $form->field($model, 'quant_receber') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'data_criacao') ?>

    <?php // echo $form->field($model, 'data_conclusao') ?>

    <?php // echo $form->field($model, 'comentarios') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
