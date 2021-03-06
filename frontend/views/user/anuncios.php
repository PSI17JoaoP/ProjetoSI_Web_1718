<?php
/**
 * @var $this yii\web\View
 * @var $anuncios array
 * @var $tipo string
 * @var $titulo string
 * @var $mensagem string
 * @var $anunciosConcluidos array
 */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Os meus anúncios';
?>

<?= $this->renderAjax('//modals/modal',[
    'header' => "Detalhes",
    'backdrop' => 'true',
    'keyboard' => 'true',
    'content' => '//modals/contacto',
    'options' => [
        //'model' => $anuncio,
        //'categorias' => $dados[1],
    ],
]) ?>

<div class="col-12">
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
            <a onclick="$('#c-detalhes').collapse('toggle')"><strong>Anúncios concluídos</strong></a>
        </div>
        <div id="c-detalhes" class="panel-body contactos-detalhes panel-collapse collapse in">
            <?php foreach($anunciosConcluidos as $dados) { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                    <div class="col-md-2">
                                            <?php
                                            if($dados['path'] != null)
                                            {
                                                echo "<img id='pesquisa_row_imagem' src='../../../common/images/". $dados['path'] ."' alt='' width = '75px' height = '75px'>";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-2">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados["titulo"]) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="margin-top: 12px; margin-left: 5px"><b>Concluído em:</b><?= Html::encode($dados["dataConclusao"]) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="pull-right">
                                                <?= Html::a('Detalhes de Contato', 'javascript:', [
                                                    'class' => 'btn btn-primary view_details',
                                                    'data-detail' => Url::toRoute(['user/detalhes-contacto']), 
                                                    'data-iduser' => $dados["idUser"],
                                                    'data-iduserproposta' => $dados["idUserProposta"],
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

<div class="col-12"> 
    <div class="panel panel-default">
        <div class="panel-heading">
            <a onclick="$('#c-ativos').collapse('toggle')"><strong>Anúncios Ativos</strong></a>
        </div>
        <div id="c-ativos" class="panel-body anuncio-detalhes panel-collapse collapse in">

            <?php foreach($anuncios as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                            <?php
                                            if($dados[0]->imagensAnuncios != null)
                                            {
                                                echo "<img id='pesquisa_row_imagem' src='../../../common/images/". $dados[0]->imagensAnuncios[0]->path_relativo ."' alt='' width = '75px' height = '75px'>";
                                            }
                                            ?>
                                    </div>

                                    <div class="col-md-6">
                                        <p style="margin-top: 8px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados[0]->titulo) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', 'javascript:', [
                                                'class' => 'btn btn-primary view_model',
                                                'data-detail' => Url::toRoute(['anuncio/detalhes']), 
                                                'data-id' => $dados[0]->id
                                                ])?>

                                            <?= Html::a('Eliminar', ['anuncio/delete', 'id' => $dados[0]->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'method' => 'post'
                                                    ]
                                            ]) ?>
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

<div class="col-12"> 
    <div class="panel panel-default">
        <div class="panel-heading">
            <a onclick="$('#c-fechados').collapse('toggle')"><strong>Anúncios Fechados</strong></a>
        </div>
        <div id="c-fechados" class="panel-body anuncio-detalhes panel-collapse collapse in">

            <?php foreach($anunciosFechados as $dados) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default panel-collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                            <?php
                                            if($dados[0]->imagensAnuncios != null)
                                            {
                                                echo "<img id='pesquisa_row_imagem' src='../../../common/images/". $dados[0]->imagensAnuncios[0]->path_relativo ."' alt='' width = '75px' height = '75px'>";
                                            }
                                            ?>
                                        </div>
                                    <div class="col-md-6">
                                        <p style="margin-top: 8px; margin-left: 5px"><b>Título:</b><?= Html::encode($dados[0]->titulo) ?></p>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', 'javascript:', [
                                                'class' => 'btn btn-primary view_model',
                                                'data-detail' => Url::toRoute(['anuncio/detalhes']), 
                                                'data-id' => $dados[0]->id
                                                ])?>

                                                <?= Html::a('Eliminar', ['anuncio/delete', 'id' => $dados[0]->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'method' => 'post'
                                                    ]
                                                ]) ?>
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
