<?php
/* @var $this yii\web\View */
/* @var $anuncios array */

use yii\helpers\Html;

$this->title = 'Os meus anúncios';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php

            foreach($anuncios as $anuncio) {

                if($anuncio !== null) { ?>

                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-6 col-md-4"><?= Html::encode($anuncio->titulo) ?></div>
                                        <div class="col-12 col-md-8">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalhesModal">Detalhes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <?= Html::a('Eliminar', ['delete'], ['class' => 'btn btn-danger']) ?>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>