<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>


<?php

$form = ActiveForm::begin(['id' => 'cliente-form']); 

echo $form->field($model, 'nomeCompleto')->textInput();

echo $form->field($model, 'dataNasc')->input('date');

echo $form->field($model, 'telefone')->input('number');

echo $form->field($model, 'regiao')->dropDownList([
    'Aveiro' => "Aveiro",
    'Beja' => "Beja",
    'Braga' => "Braga",
    'Bragança' => "Bragança",
    'Castelo Branco' => "Castelo Branco",
    'Coimbra' => "Coimbra",
    'Évora' => "Évora",
    'Faro' => "Faro",
    'Guarda' => "Guarda",
    'Leiria' => "Leiria",
    'Lisboa' => "Lisboa",
    'Portalegre' => "Portalegre",
    'Porto' => "Porto",
    'Santarém' => "Santarém",
    'Setúbal' => "Setúbal",
    'Viana do Castelo' => "Viana do Castelo",
    'Vila Real' => "Vila Real",
    'Viseu' => "Viseu",
    'Açores' => "Açores",
    'Madeira' => "Madeira"
]);

?>

<?php


echo "
<div class='row'>
<span class='pull-right' style='padding-right:13px'>";

echo Html::submitButton('Guardar', ['class' => 'btn btn-primary btn-lg', 'name' => 'clienteInfo-button pull-right']);

echo "</span>
</div>";
ActiveForm::end();
?>

