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

            <?php foreach($propostas as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="margin-top: 12px; margin-left: 5px"><?= Html::encode($dados[1][0]->nome) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary view_model'])?>
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="pull-right">
                                                    <?= Html::a('Aceitar', ['proposta/update', 'propostaID' => $dados[0]->id], [
                                                        'class' => 'btn btn-success',
                                                        'style' => 'margin-left: 17px; margin-top: 13px',
                                                        'data' => [
                                                            'method' => 'post',
                                                            'params' => [
                                                                'estado' => 'ACEITE',
                                                            ],
                                                        ]
                                                    ]); ?>
                                                </span>
                                            </div>

                                            <div class="col-md-6">
                                                <span class="pull-right">
                                                    <?= Html::a('Recusar', ['proposta/update', 'propostaID' => $dados[0]->id], [
                                                        'class' => 'btn btn-danger',
                                                        'style' => 'margin-left: 17px; margin-top: 13px',
                                                        'data' => [
                                                            'method' => 'post',
                                                            'params' => [
                                                                'estado' => 'RECUSADO',
                                                            ],
                                                        ]
                                                    ]); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= $this->renderAjax('//modals/modal',[
                        'header' => $dados[1][0]->nome,
                        'backdrop' => 'true',
                        'keyboard' => 'true',
                        'content' => '//modals/proposta',
                        'options' => [
                            'model' => $dados[0],
                            'categorias' => $dados[1],
                        ],
                    ]) ?>

                </div>
        <?php } ?>
    </div>
</div>
