<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\materialicons\MD;

?>

<div class="panel panel-primary">
    <div class="panel-body">
        <div class="col-md-3">
            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
        </div>

        <div class="col-md-2" style="text-align: center">
            <?= MD::icon(MD::_SWAP_HORIZ, ['style' => 'font-size: 50px']) ?>
        </div>

        <div class="col-md-3">
            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
        </div>

        <?php if(!Yii::$app->user->isGuest) { ?>

            <div class="col-md-4">

                <?php if($anuncio->quant_receber !== null) {

                    // Forma alternativa do botão de enviar proposta,
                    // em que neste passa todos os dados para no controller apenas fazer load() ao modelo.
                    // Menos segura visto que coloca os dados na tag html.

                    /*echo Html::a('Enviar Proposta', ['proposta/create'], [
                        'class' => 'btn btn-info',
                        'style' => 'margin-left: 17px; margin-top: 15px',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Tem a certeza que deseja enviar uma proposta ?',
                            'params' => [
                                'cat_proposto' => $anuncio->cat_receber,
                                'quant' => $anuncio->quant_receber,
                                'data_proposta' => date("Y-m-d h:i:s"),
                                'estado' => 'ABERTA',
                                'id_user' => Yii::$app->user->identity->getId(),
                                'id_anuncio' => $anuncio->id,
                            ],
                        ]
                    ]);*/

                    echo Html::a('Enviar Proposta', ['proposta/create'], [
                        'class' => 'btn btn-info',
                        'style' => 'margin-left: 17px; margin-top: 13px',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Tem a certeza que deseja enviar uma proposta ?',
                            'params' => [
                                'id_anuncio' => $anuncio->id,
                            ],
                        ]
                    ]);
                }

                else {
                    echo Html::a('Enviar Proposta', ['proposta/create', 'id' => $anuncio->id],
                        ['class' => 'btn btn-info',
                        'style' => 'margin-left: 17px; margin-top: 13px']);
                } ?>

            </div>

        <?php } ?>
    </div>
</div>