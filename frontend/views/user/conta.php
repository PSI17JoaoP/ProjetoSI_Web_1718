<?php
/** @var $this yii\web\View
 * @var $model common\models\Cliente
 * @var $regioes array
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="col-12 col-md-12">
<?php
    if($tipo != null)
    {
        echo $this->render('//alerts/alert', [
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensagem' => $mensagem
        ]);
    }
?>  
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Dados de utilizador</h4>
        </div>

        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'conta-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="row">
                <div class="col-md-4">
                    <img src="../../../common/images/<?= $model->pathImage?>" width="200px" height="200px">
                    <?= $form->field($model, 'imageFile')->fileInput(['class'=>'sr-only'])->label(null,['class'=>'btn btn-success btn-sm']) ?>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $form->field($model, 'nomeCompleto')->textInput() ?>

                            <?= $form->field($model, 'dataNasc')->input('date') ?>

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
                            
                            <?= $form->field($model, 'catPref')->checkboxList($categorias); ?>
                            
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