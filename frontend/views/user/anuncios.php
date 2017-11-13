<?php
/* @var $this yii\web\View */

use common\models\Anuncio;
use common\models\ImagensAnuncio;
use yii\helpers\Html;

$this->title = 'Os meus anúncios';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php

            $anuncios = Anuncio::findAll(['id_user' => Yii::$app->user->identity->getId()]);

            foreach($anuncios as $anuncio) {

                if($anuncio !== null) {

                    $imagens = ImagensAnuncio::findAll(['anuncio_id' => $anuncio->id]) ?>

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

                        <div class="modal fade" id="detalhesModal" tabindex="-1" role="dialog" aria-labelledby="detalhesModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detalhesModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">



                                    </div>
                                    <div class="modal-footer">
                                        <?= Html::a('Eliminar', ['delete'], ['class' => 'btn btn-danger']) ?>

                                        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
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