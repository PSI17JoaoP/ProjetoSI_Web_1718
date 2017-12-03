<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\AnuncioSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-body">
                <div class="pesquisa-control" data-info="<?= Url::toRoute(['anuncio/search']); ?>"/>

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

<?php
        foreach($anuncios as $anuncio) {

            if($anuncio !== null) { ?>

                <div class="row pesquisa-row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="margin-top: 8px; margin-left: 5px" id="pesquisa_row_titulo"><?= Html::encode($anuncio['titulo']) ?></p>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary showModal'])?>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php       }
        }         
?>

</div>