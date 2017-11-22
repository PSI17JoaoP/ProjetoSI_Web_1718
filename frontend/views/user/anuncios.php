<?php
/* @var $this yii\web\View */
/* @var $anuncios array */

use yii\helpers\Html;

$this->title = 'Os meus anúncios';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">

            <?php foreach($anuncios as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="margin-top: 8px; margin-left: 5px"><?= Html::encode($dados[0]->titulo) ?></p>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary view_model'])?>
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

                    <?= $this->renderAjax('//modals/modal',[
                        'header' => $dados[0]->titulo,
                        'backdrop' => 'true',
                        'keyboard' => 'true',
                        'content' => '//modals/anuncio',
                        'options' => [
                            'model' => $dados[0],
                            'categorias' => $dados[1],
                        ],
                    ]) ?>

                </div>

            <?php } ?>
        </div>
    </div>
</div>