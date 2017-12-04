<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Pesquisa de Anúncios';

/* @var $this yii\web\View */
/* @var $model common\models\AnuncioSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $categorias array */
/* @var $regioes array */
/* @var $anuncios array */

?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pesquisa-control" data-info="<?= Url::toRoute(['anuncio/search']); ?>"></div>

            <div class="col-md-12" style="margin-bottom: 10px">
                <?= Html::textInput('titulo', null, ['class' => 'form-control pesquisa-control', 'placeholder' => 'Pesquisar...', 'id' => 'pesquisa_titulo']) ?>
            </div>

            <div class="col-md-6">
                <?= Html::dropDownList('categoria', 'categoria', $categorias,
                    ['class' => 'form-control', 'style' => "margin-bottom: 10px", 'prompt' => 'Categoria ...', 'id' => 'pesquisa_categoria'])?>
            </div>

            <div class="col-md-6">
                <?= Html::dropDownList('regiao', 'regiao', $regioes,
                    ['class'=>'form-control', 'style' => "margin-bottom: 10px", 'prompt' => 'Região ...', 'id' => 'pesquisa_regiao'])?>
            </div>
        </div>
    </div>
</div>

<div class="anuncio-search">

    <?php foreach($anuncios as $anuncio) {

            if($anuncio !== null) { ?>

            <div class="row pesquisa-row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p style="margin-top: 8px; margin-left: 5px" id="pesquisa_row_titulo"><?= Html::encode($anuncio['titulo']) ?></p>
                                </div>

                                <div class="col-md-4">
                                    <span class="pull-right">
                                        <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary view_model'])?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?= $this->renderAjax('//modals/modal',[
                    'header' => $anuncio['titulo'],
                    'backdrop' => 'true',
                    'keyboard' => 'true',
                    'content' => '//modals/anuncio',
                    'options' => [
                        //'model' => $anuncio,
                        //'categorias' => $dados[1],
                    ],
                ]) ?>

            </div>

        <?php } ?>
    <?php } ?>
</div>