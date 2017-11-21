<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, "[$i]nome")->textInput();

echo $form->field($model, "[$i]marca")->textInput();

echo $form->field($model, "[$i]descricao")->textArea();

echo $form->field($model, "[$i]processador")->textInput();

echo $form->field($model, "[$i]ram")->textInput();

echo $form->field($model, "[$i]hdd")->textInput();

echo $form->field($model, "[$i]gpu")->textInput();

echo $form->field($model, "[$i]os")->textInput();

echo $form->field($model, "[$i]portatil")->dropDownList(['Não', 'Sim'], [
    'class'=>'form-control'
]);