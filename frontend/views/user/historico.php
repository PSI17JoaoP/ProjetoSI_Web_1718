<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Histórico';
?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-6 col-md-4">
                    <a href="#" class="btn btn-primary">Anúncios</a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#" class="btn btn-primary">Propostas</a>
                </div>
                <div class="col-6 col-md-4">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Ordenar por: </a>
                        <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Opção 1</a></li>
                            <li><a href="#">Opção 2</a></li>
                            <li><a href="#">Opção 3</a></li>
                            <li><a href="#">Opção 4</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--Código repetido para efeito de visualização com multiplos paineis-->

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">                        
                    
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

        </div>
    </div>
</div>