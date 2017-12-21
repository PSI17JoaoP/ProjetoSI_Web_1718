<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropostaForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $listaCategorias array */
/* @var $anuncio integer */

?>

<div class="proposta-form">
    <div class="col-md-8">
        <div class="panel panel-default">

            <?php $form = ActiveForm::begin(['id' => 'proposta-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'anuncioID')->hiddenInput(['value' => $anuncio])->label(false) ?>

            <div class="panel-body">
                <div class="col-md-12">

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">

                                        <?= $form->field($model, 'catProposto')->dropDownList($listaCategorias, [
                                        'onchange' => '$.pjax.reload({
                                                        url: "' . Url::toRoute(['create']) . '?anuncio=' . $anuncio . '&catProposto="+$(this).val(),
                                                        container: "#pjax-dynamic-form-proposta",
                                                        timeout: 1000,
                                        });',
                                        'class'=>'form-control',
                                        'prompt' => 'Selecione a categoria']) ?>

                                    </div>

                                    <div class="row">

                                        <?php Pjax::begin(['id' => 'pjax-dynamic-form-proposta', 'enablePushState' => false]) ?>

                                        <?= $form->field($model, 'quantProposto')->textInput(['type' => 'number']); ?>

                                        <?php

                                            switch ($model->catProposto)
                                            {
                                                case 'brinquedos':

                                                    echo $this->render('//forms/brinquedos', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'jogos':

                                                    echo $this->render('//forms/jogos', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'eletronica':

                                                    echo $this->render('//forms/eletronica', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'computadores':

                                                    echo $this->render('//forms/computadores', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'smartphones':

                                                    echo $this->render('//forms/smartphones', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'livros':

                                                    echo $this->render('//forms/livros', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'roupa':

                                                    echo $this->render('//forms/roupa', [
                                                        'form' => $form,
                                                        'model' => $model->modelProposto,
                                                        'i' => 0,
                                                    ]);
                                            }

                                        ?>

                                        <?php Pjax::end() ?>

                                    </div>
                                    <div class="row">
                                        <?= $form->field($model, 'imageFiles')->fileInput(['multiple' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <span class="pull-right">
                            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary btn-lg', 'name' => 'proposta-button pull-right']) ?>
                        </span>
                    </div>

                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
