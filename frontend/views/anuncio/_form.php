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

                                <?= $form->field($model, 'type')->dropDownList($catItems,
                                [
                                'onchange'=>'
                                    $.pjax.reload({
                                    url: "'. Url::toRoute(['create']).'?type="+$(this).val(),
                                    container: "#pjax-dynamic-form",
                                    timeout: 1000,
                                    });
                                ',

                                'class'=>'form-control',
                                'prompt' => 'Seleciona a categoria'
                                ]) ?>
                            </div>
                            <div class="row">
                            <?php  Pjax::begin(['id'=>'pjax-dynamic-form','enablePushState'=>false]); ?>
                            
                            <?php
                                if($model->type==='brinquedos'){
                                    echo $form->field($model, 'editora')->textInput();
                                    echo $form->field($model, 'descricao')->textArea();
                                }
                            ?>

                            <?php Pjax::end(); ?>  
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-8">
                        <a href="#" class="btn btn-danger">Adicionar</a>
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
                            <div class="col-6 col-md-4">Outro Produto</div>
                            <div class="col-12 col-md-8">
                                <span class="pull-right"><a href="#"><u>Remover</u></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-8">
                    <a href="#" class="btn btn-danger">Adicionar</a>
                    </div>
                </div>
            </div>
        </div>

        <h4>Comentário</h4>    

            <div class="form-group">                
                 <div class="col-lg-10">
                    <textarea class="form-control" rows="3" id="textArea"></textarea>
                     <span class="help-block">Adicione aqui comentários adicionais referentes ao anuncio.</span>
                 </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-lg-10">
            <a href="#" class="btn btn-primary btn-lg" style="">Criar Anúncio</a>
            </div>
        </div>
    </div>
        
        
    </div>

    <?php ActiveForm::end(); ?>    
</div>
</div>
