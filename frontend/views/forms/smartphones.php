<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, 'nome')->textInput();

echo $form->field($model, 'marca')->textInput();

echo $form->field($model, 'descricao')->textArea();

echo $form->field($model, 'processador')->textInput();

echo $form->field($model, 'ram')->textInput();

echo $form->field($model, 'hdd')->textInput();

echo $form->field($model, 'os')->textInput();

echo $form->field($model, 'tamanho')->textInput();