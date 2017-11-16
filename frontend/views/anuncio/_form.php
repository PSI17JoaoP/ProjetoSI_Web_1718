<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\AnuncioForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $catItems array */

?>

<div class="anuncio-form">
    <div class="col-md-8">
        <div class="panel panel-default">

            <?php $form = ActiveForm::begin(['id' => 'anuncio-form']); ?>

            <div class="panel-heading">
                <h3><?= $form->field($model, 'titulo')->textInput(['class' => 'form-control']) ?></h3>
            </div>

            <div class="panel-body">
                <div class="col-md-12">
                    <h3>Troco:</h3>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">

                                    <?= $form->field($model, 'catOferta')->dropDownList($catItems,
                                    [
                                    'onchange'=>'
                                        $.pjax.reload({
                                        url: "'. Url::toRoute(['create']).'?catOferta="+$(this).val(),
                                        container: "#pjax-dynamic-form-oferta",
                                        timeout: 1000,
                                        });
                                    ',

                                    'class'=>'form-control',
                                    'prompt' => 'Selecione a categoria']) ?>

                                    </div>

                                    <div class="row">

                                        <?php  Pjax::begin(['id'=>'pjax-dynamic-form-oferta','enablePushState'=>false]); ?>

                                        <?= $form->field($model, 'quantOferta')->textInput(['type' => 'number']); ?>

                                        <?php

                                            switch ($model->catOferta)
                                            {
                                                case 'brinquedos':

                                                    echo $this->render('//forms/brinquedos', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'jogos':

                                                    echo $this->render('//forms/jogos', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'eletronica':

                                                    echo $this->render('//forms/eletronica', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'computadores':

                                                    echo $this->render('//forms/computadores', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'smartphones':

                                                    echo $this->render('//forms/smartphones', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'livros':

                                                    echo $this->render('//forms/livros', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);

                                                    break;

                                                case 'roupa':

                                                    echo $this->render('//forms/roupa', [
                                                        'form' => $form,
                                                        'model' => $model->mOferta,
                                                        'i' => 0,
                                                    ]);
                                            }

                                        ?>

                                        <?php Pjax::end(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3>Por:</h3>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <?= $form->field($model, 'catProcura')->dropDownList(['todos' => 'Qualquer coisa']+$catItems,
                                            [
                                            'onchange'=>'
                                                $.pjax.reload({
                                                url: "'. Url::toRoute(['create']).'?catProcura="+$(this).val(),
                                                container: "#pjax-dynamic-form-procura",
                                                timeout: 1000,
                                                });
                                            ',

                                            'class'=>'form-control',
                                            'prompt' => 'Selecione a categoria'
                                        ]) ?>
                                    </div>

                                    <div class="row">

                                        <?php  Pjax::begin(['id'=>'pjax-dynamic-form-procura','enablePushState'=>false]); ?>

                                        <?php

                                            if ($model->catProcura!=='todos') {
                                                echo $form->field($model, 'quantProcura')->textInput(['type' => 'number']);
                                            }

                                            ?>

                                        <?php

                                        switch ($model->catProcura)
                                        {
                                            case 'brinquedos':

                                                echo $this->render('//forms/brinquedos', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'jogos':

                                                echo $this->render('//forms/jogos', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'eletronica':

                                                echo $this->render('//forms/eletronica', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'computadores':

                                                echo $this->render('//forms/computadores', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'smartphones':

                                                echo $this->render('//forms/smartphones', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'livros':

                                                echo $this->render('//forms/livros', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);

                                                break;

                                            case 'roupa':

                                                echo $this->render('//forms/roupa', [
                                                    'form' => $form,
                                                    'model' => $model->mProcura,
                                                    'i' => 1,
                                                ]);
                                        }

                                        ?>

                                        <?php Pjax::end(); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                         <h4>
                                             <?= $form->field($model, 'comentarios')
                                                 ->textArea(['rows' => '4', 'style' => 'resize: none']) ?>
                                         </h4>
                                        <span class="help-block">Adicione aqui comentários adicionais referentes ao anuncio.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <span class="pull-right">
                            <?= Html::submitButton('Concluído', ['class' => 'btn btn-primary btn-lg', 'name' => 'anuncio-button pull-right']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
