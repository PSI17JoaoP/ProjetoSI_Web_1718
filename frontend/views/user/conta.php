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
            <p>Dados de utilizador</p>
        </div>

        <div class="box-body">

            <?php $form = ActiveForm::begin(['id' => 'conta-form']); ?>

            <div class="row" style="padding-bottom: 5%">

                <div class="col-md-4" >
                    <img src="" width="125px" height="125px" >
                    <button class="btn btn-default btn-sm">Escolher Imagem...</button>
                </div>

                <div class="col-md-8">

                    <label for="nomeUser">Nome:</label>
                    <?= $form->field($model, 'nome_completo')->textInput() ?>

                    <label for="telefone">Nº Telemóvel:</label>
                    <?= $form->field($model, 'telefone')->textInput(['type' => 'number']) ?>

                    <label for="regiaoUser">Região:</label>
                    <?= $form->field($model, 'regiao')->dropDownList($regioes, ['prompt' => '']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p>Categoria(s) preferida(s)</p>
                        </div>
                        <div class="panel-body">
                            <?/*= $form->field()->checkboxList()*/?>
                            <div class="checkbox">
                                <label><input type="checkbox" value="brinquedos">Brinquedos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="jogos">Jogos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="eletronica">Eletrónica</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="computadores">Computadores</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="smartphones">Smartphones</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="livros">Livros</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="roupa">Roupa</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer" align="right">
                <?= Html::submitButton('Concluido', ['class' => 'btn btn-default btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>