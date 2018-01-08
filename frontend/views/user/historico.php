<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;



$this->title = 'Histórico';
?>

<div class="col-12">

        <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Histórico</strong>
        </div>
            <div class="panel-body">


                <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#anuncios" style="">Anúncios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#propostas" style="">Propostas</a>
                </li>
                
                
                </ul>
                <div id="myTabContent" class="tab-content">
                <div class="tab-pane active" id="anuncios">
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
                </div>
                <div class="tab-pane fade" id="propostas">
                <?php foreach($propostas as $dados) { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Proposta:</b><?= Html::encode($dados[1][0]->nome) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Proposto em:</b><?= Html::encode($dados[0]->data_proposta) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Estado:</b><?= Html::encode($dados[0]->estado) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>              
                    </div>

                <?php } ?>
            </div>
                
                 
        </div>
        </div>
        </div>
     
</div>