<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Anuncio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anuncio-form">

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        
        <?php $form = ActiveForm::begin(['id' => 'anuncio-form']); ?>

        <div class="panel-heading">
            <h3>
                <?= $form->field($model, 'titulo')->textInput(['class' => 'form-control']) ?>
            </h3>
        </div>

        <div class="panel-body">
        
        <h3>Troco:</h3>

        <div class="row">
                <div class="col-12 col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
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
                                'prompt' => 'Selecione a categoria'
                                ]) ?>
                            </div>
                            <div class="row">
                            <?php  Pjax::begin(['id'=>'pjax-dynamic-form-oferta','enablePushState'=>false]); ?>
                            
                            <?php
                                if($model->catOferta==='brinquedos'){
                                    echo $form->field($model->mOferta, 'nome')->textInput();
                                    echo $form->field($model->mOferta, 'faixaEtaria')->textInput(['type' => 'number']);
                                    echo $form->field($model->mOferta, 'editora')->textInput();
                                    echo $form->field($model->mOferta, 'descricao')->textArea();
                                }
                                if ($model->catOferta==='jogos') {
                                    echo $form->field($model->mOferta, 'nome')->textInput();
                                    echo $form->field($model->mOferta, 'faixaEtaria')->textInput(['type' => 'number']);
                                    echo $form->field($model->mOferta, 'editora')->textInput();
                                    echo $form->field($model->mOferta, 'descricao')->textArea();
                                    echo $form->field($model->mOferta, 'produtora')->textInput();
                                    echo $form->field($model->mOferta, 'genero')->dropDownList($model->mOferta->generoList, 
                                    [
                                    'class'=>'form-control',
                                    'prompt' => 'Selecione o género'
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
                <div class="col-12 col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
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
                                if($model->catProcura==='brinquedos'){
                                    echo $form->field($model->mProcura, 'nome', ['inputOptions' => ['id' => 'channel-description']])->textInput();
                                    echo $form->field($model->mProcura, 'faixaEtaria')->textInput(['type' => 'number']);                                    
                                    echo $form->field($model->mProcura, 'editora')->textInput();
                                    echo $form->field($model->mProcura, 'descricao')->textArea(['style' => 'resize: none']);
                                }
                                if ($model->catProcura==='jogos') {
                                    echo $form->field($model->mProcura, 'nome')->textInput();
                                    echo $form->field($model->mProcura, 'faixaEtaria')->textInput(['type' => 'number']);
                                    echo $form->field($model->mProcura, 'editora')->textInput();
                                    echo $form->field($model->mProcura, 'descricao')->textArea(['style' => 'resize: none']);
                                    echo $form->field($model->mProcura, 'produtora')->textInput();
                                    echo $form->field($model->mProcura, 'genero')->dropDownList($model->mProcura->generoList, 
                                    [
                                    'class'=>'form-control',
                                    'prompt' => 'Selecione o género'
                                    ]);
                                }
                            ?>

                            <?php Pjax::end(); ?>  
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <h4>Comentário</h4>    

            <div class="form-group">                
                 <div class="col-lg-8">
                    <?= $form->field($model, 'comentarios')->textArea(
                        ['rows' => '4', 'style' => 'resize: none']);?>
                    <span class="help-block">Adicione aqui comentários adicionais referentes ao anuncio.</span>
                 </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-lg-12">
                <span class="pull-right">
                    <?= Html::submitButton('Concluído', ['class' => 'btn btn-primary btn-lg', 'name' => 'anuncio-button pull-right']) ?>
                </span>
            </div>
        </div>
    </div>
        
        
    </div>

    <?php ActiveForm::end(); ?>    
</div>
</div>
