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

            foreach($anuncios as $anuncio) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="margin-top: 8px; margin-left: 5px"><?= Html::encode($anuncio->titulo) ?></p>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary showModal'])?>
                                        </span>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            <?= Html::a('Eliminar', ['delete'], ['class' => 'btn btn-danger']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo $this->renderAjax('//modals/modal',[
                        'id' => 'modal_detalhes',
                        'header' => $anuncio->titulo,
                        'backdrop' => 'true',
                        'keyboard' => 'true',
                        'model' => $anuncio,
                        'content' => '//modals/anuncio']) ?>

            <?php } ?>
        </div>
    </div>
</div>