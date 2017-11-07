<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropostaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proposta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cat_proposto') ?>

    <?= $form->field($model, 'quant') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'id_anuncio') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'data_proposta') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
