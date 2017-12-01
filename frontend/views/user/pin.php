<?php

/** @var \common\models\Cliente $model */

use yii\helpers\Html;

$this->title = 'PIN Móvel'

?>

<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Gerar PIN</h4>
        </div>

        <div class="panel-body">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <p style="text-align: center;">Clique no botão "Gerar PIN" para gerar um PIN para acesso móvel.</p>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <div class="row align-items-center">
                        <div class="col-md-3"></div>

                        <div class="col-md-6" style="border: 4px #0a0a0a;">

                            <?php if($model->pin !== null) {
                                echo Html::tag('p', $model->pin);
                            }

                            echo Html::a('Gerar PIN', ['pin', 'id' => $model->id_user], [
                                    'class' => 'btn btn-default',
                                    'style' => 'margin-left: 17px; margin-top: 13px']); ?>

                        </div>

                        <div class="col-md-3"></div>
                    </div>
                </div>

                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</div>
