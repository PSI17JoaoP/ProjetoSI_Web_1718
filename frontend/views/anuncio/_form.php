<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Anuncio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anuncio-form">

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">
        
        <h3>Troco:</h3>

        <div class="row">
                <div class="col-12 col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-6 col-md-4">Produto 1</div>
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

    
</div>


</div>