<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;

?>

<div class="col-6 col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav">
                <li class="nav-item">
                    <?= Html::a('Definições da Conta', 'conta', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Anúncios', 'anuncios', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Propostas', 'propostas', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Histórico', 'historico', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Gerar PIN Móvel', 'pin', ['class' => 'nav-link'])?>
                </li>
            </ul>
        </div>
    </div>
</div>