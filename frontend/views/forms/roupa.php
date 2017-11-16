<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model */
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, "[$i]nome")->textInput();

echo $form->field($model, "[$i]marca")->textInput();

echo $form->field($model, "[$i]tamanho")->textInput();

echo $form->field($model, "[$i]tipoRoupa")->dropDownList($model->tipoRoupaList, [
        'class'=>'form-control',
        'prompt' => 'Selecione o tipo de roupa'
    ]);