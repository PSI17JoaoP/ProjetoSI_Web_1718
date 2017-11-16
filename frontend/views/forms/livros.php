<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, "[$i]nome")->textInput();

echo $form->field($model, "[$i]titulo")->textInput();

echo $form->field($model, "[$i]editora")->textInput();

echo $form->field($model, "[$i]autor")->textInput();

echo $form->field($model, "[$i]isbn")->textInput(['type' => 'number']);