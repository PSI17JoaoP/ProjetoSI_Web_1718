<?php
/** @var $this yii\web\View
 * @var $model common\models\Cliente
 * @var $regioes array
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Dados de utilizador</h4>
        </div>

        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'conta-form']); ?>

            <div class="row">
                <div class="col-md-4">
                    <img src="" width="100%" height="75%">
                    <button class="btn btn-default btn-sm">Escolher Imagem</button>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $form->field($model, 'nome_completo')->textInput() ?>

                            <?= $form->field($model, 'telefone')->textInput(['type' => 'number']) ?>

                            <?= $form->field($model, 'regiao')->dropDownList($regioes, ['prompt' => 'Região ...']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Categoria(s) preferida(s)</h4>
                        </div>
                        <div class="panel-body">
                            
                            <?= $form->field($model->user, 'categoriasPreferidas')->checkBoxList($categorias); ?>
                            
                        </div>

                        <div class="panel-footer" align="right">
                            <?= Html::submitButton('Concluido', ['class' => 'btn btn-default btn-lg']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>