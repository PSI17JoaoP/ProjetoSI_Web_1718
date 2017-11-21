<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, "[$i]nome")->textInput();

echo $form->field($model, "[$i]faixaEtaria")->textInput(['type' => 'number']);

echo $form->field($model, "[$i]editora")->textInput();

echo $form->field($model, "[$i]descricao")->textArea();