<?php

/* @var $this yii\web\View */
/* @var $model yii\base\Model*/
/* @var $form yii\widgets\ActiveForm */

echo $form->field($model, 'nome')->textInput();

echo $form->field($model, 'faixaEtaria')->textInput(['type' => 'number']);

echo $form->field($model, 'editora')->textInput();

echo $form->field($model, 'descricao')->textArea();

echo $form->field($model, 'produtora')->textInput();

echo $form->field($model, 'genero')->dropDownList($model->generoList, [
        'class'=>'form-control',
        'prompt' => 'Selecione o género'
    ]);