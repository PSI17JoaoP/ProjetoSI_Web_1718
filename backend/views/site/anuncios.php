<?php

use yii\helpers\Url;
use common\models\Tools;

/* @var $this yii\web\View */

$this->title = 'Estatísticas - Anúncios';

dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-anuncios">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Popularidade de categorias</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body with-border">
                </div>
                <div class="box-body">
                    <canvas id="pieChart" style="height:250px" data-info="<?= Url::toRoute(['site/pie-info']) ?>"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Nº Anúncios por Mês</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="areaChart" style="height:250px" data-info="<?= Url::toRoute(['site/anuncios']) ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>