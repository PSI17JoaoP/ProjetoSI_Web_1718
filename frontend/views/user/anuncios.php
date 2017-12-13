<?php
/* @var $this yii\web\View */
/* @var $anuncios array */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Os meus anúncios';
?>

<?= $this->renderAjax('//modals/modal',[
    'header' => "Detalhes",
    'backdrop' => 'true',
    'keyboard' => 'true',
    'content' => '//modals/anuncio',
    'options' => [
        //'model' => $anuncio,
        //'categorias' => $dados[1],
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
            <strong>Anúncios concluídos</strong>                            
        </div>
        <div class="panel-body">
            <?php foreach($anunciosConcluidos as $dados) { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados["titulo"]) ?></p>
                                        </div>

                                        <div class="col-md-4">
                                            <span class="pull-right">
                                                <?= Html::a('Detalhes de Contato', 'javascript:', [
                                                    'class' => 'btn btn-primary ',
                                                    'data-detail' => Url::toRoute(['/']), 
                                                    'data-idUser' => $dados["idUser"],
                                                    'data-idUserProposta' => $dados["idUserProposta"],
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

<div class="col-12 col-md-8"> 
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Anúncios Ativos</strong>                            
        </div>
        <div class="panel-body anuncio-detalhes">

            <?php foreach($anuncios as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="margin-top: 8px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados[0]->titulo) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', 'javascript:', [
                                                'class' => 'btn btn-primary view_model',
                                                'data-detail' => Url::toRoute(['anuncio/detalhes']), 
                                                'data-id' => $dados[0]->id
                                                ])?>

                                            <?= Html::a('Eliminar', ['delete'], ['class' => 'btn btn-danger']) ?>
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
