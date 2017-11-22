<?php
/* @var $this yii\web\View
 * @var $propostas array
 */

use yii\helpers\Html;

$this->title = 'Propostas Recebidas';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php

            foreach($propostas as $proposta) {
                
                if($proposta !== null) { ?>

                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-6 col-md-4"><?= Html::encode($proposta->nome) ?></div>
                                        <div class="col-12 col-md-8">
                                            <span class="pull-right"><a href="#"><u>Detalhes</u></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">

                            <div class="col-md-6">

                            <?= Html::a('Aceitar', ['proposta/update', 'propostaID' => $proposta->id], [
                                'class' => 'btn btn-success',
                                'style' => 'margin-left: 17px; margin-top: 13px',
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'estado' => 'ACEITE',
                                    ],
                                ]
                            ]); ?>
                                
                            </div>

                            <div class="col-md-6">

                            <?= Html::a('Recusar', ['proposta/update', 'propostaID' => $proposta->id], [
                                'class' => 'btn btn-danger',
                                'style' => 'margin-left: 17px; margin-top: 13px',
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'estado' => 'RECUSADO',
                                    ],
                                ]
                            ]); ?>
                                
                            </div>
                        </div>
                    </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
