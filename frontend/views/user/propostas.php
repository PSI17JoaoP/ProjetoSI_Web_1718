<?php
/* @var $this yii\web\View
 * @var $propostas array
 */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Propostas Recebidas';
?>


<?= $this->renderAjax('//modals/modal',[
        'header' => "Detalhes",
        'backdrop' => 'true',
        'keyboard' => 'true',
        'content' => '//modals/proposta',
        'options' => [
        ],
    ]) ?>

<div class="col-12 col-md-8">
<?php
    if($tipo != null)
    {
        echo $this->render('//alerts/alert', [
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensagem' => $mensagem
        ]);
    }
?>  
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Propostas pendentes</strong>
        </div>
        <div class="panel-body anuncio-detalhes">

            <?php foreach($propostas as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="margin-top: 12px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados[1][0]->nome) ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', 'javascript:', [
                                                'class' => 'btn btn-primary view_model',
                                                'data-detail' => Url::toRoute(['anuncio/detalhes']), 
                                                'data-id' => $dados[0]->id_anuncio
                                                ])?>
                                           
                                            <?= Html::a('Aceitar', ['proposta/update', 'propostaID' => $dados[0]->id], [
                                                'class' => 'btn btn-success',
                                                'data' => [
                                                    'method' => 'post',
                                                    'params' => [
                                                        'estado' => 'ACEITE',
                                                    ],
                                                ]
                                            ]); ?>

                                            <?= Html::a('Recusar', ['proposta/update', 'propostaID' => $dados[0]->id], [
                                                'class' => 'btn btn-danger',
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
        <?php } ?>
        </div>
    </div>
</div>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Propostas aceites</strong>                            
        </div>
        <div class="panel-body contactos-detalhes">
            <?php foreach($propostasAceites as $dados) { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Anúncio:</b><?= Html::encode($dados["titulo"]) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Aceite em:</b><?= Html::encode($dados["dataConclusao"]) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="pull-right">
                                                <?= Html::a('Detalhes de Contato', 'javascript:', [
                                                    'class' => 'btn btn-primary view_details',
                                                    'data-detail' => Url::toRoute(['user/detalhes-contacto']), 
                                                    'data-idUser' => $dados["idUser"],
                                                    'data-idUserProposta' => $dados["idUserAnuncio"],
                                                    ])?>
                                            </span>
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