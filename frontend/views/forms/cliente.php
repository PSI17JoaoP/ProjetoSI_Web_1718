<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Tools;

/** @var $model frontend\models\ClienteForm */

$form = ActiveForm::begin(['id' => 'cliente-form']); 

echo $form->field($model, 'nomeCompleto')->textInput();

echo $form->field($model, 'dataNasc')->input('date');

echo $form->field($model, 'telefone')->input('number');

echo $form->field($model, 'regiao')->dropDownList(Tools::listaRegioes());

echo "<div class='row'><span class='pull-right' style='padding-right:13px'>"
 . Html::submitButton('Guardar', ['class' => 'btn btn-primary btn-lg', 'name' => 'clienteInfo-button pull-right'])
 . "</span></div>";

ActiveForm::end();
