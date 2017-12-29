<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Histórico';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-6 col-md-4">
                    <a href="#" class="btn btn-primary">Anúncios</a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="btn btn-primary">Propostas</a>
                </div>
                <div class="col-6 col-md-4">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Ordenar por: </a>
                        <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Titulo</a></li>
                            <li><a href="#">Data</a></li>
                            <li><a href="#">Estado</a></li>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>

            

            <div class="panel panel-default">
                <div class="panel-body">

                    <!--Código para apresentar os anuncios-->                      
                    
                    <?php foreach($anuncios as $dados) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p style="margin-top: 12px; margin-left: 5px"><b>Anúncio:</b><?= Html::encode($dados["titulo"]) ?></p>
                                            </div>
                                            <div class="col-md-4">
                                                <p style="margin-top: 12px; margin-left: 5px"><b>Criado em:</b><?= Html::encode($dados["data_criacao"]) ?></p>
                                            </div>
                                            <div class="col-md-4">
                                                <p style="margin-top: 12px; margin-left: 5px"><b>Estado:</b><?= Html::encode($dados["estado"]) ?></p>
                                            </div>                                                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                    
                    <!--Código para apresentar as propostas-->  

                                            

                    
                </div>
            </div>

        </div>
    </div>
</div>