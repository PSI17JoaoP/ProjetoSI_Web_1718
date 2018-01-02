<?php

use yii\helpers\Url;
use common\models\Tools;

/* @var $this yii\web\View */

$this->title = 'Estatísticas - Propostas';

dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-propostas">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Atividade/Nº de Propostas por Distrito</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="barChart" style="height:230px" data-info="<?= Url::toRoute(['site/propostas']) ?>"></canvas>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <!--<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Grafico</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                </div>
            </div>-->
        </div>
    </div>
</div>