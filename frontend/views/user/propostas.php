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

                    <!--Código repetido para efeito de visualização com multiplos paineis-->
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-6 col-md-4">Proposta 1</div>
                                        <div class="col-12 col-md-8">
                                            <span class="pull-right"><a href="#"><u>Detalhes</u></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="col-md-6">
                                <a href="#" class="btn btn-success">Aceitar</a>
                            </div>

                            <div class="col-md-6">
                                <a href="#" class="btn btn-danger">Recusar</a>
                            </div>
                        </div>
                    </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
