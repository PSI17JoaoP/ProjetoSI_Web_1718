<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;

?>

<div class="col-6 col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav">
                <li class="nav-item">
                    <?= Html::a('Definições da Conta', '#', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Anúncios', 'anuncio', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Propostas', 'propostas', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Histórico', 'history', ['class' => 'nav-link'])?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Gerar PIN Móvel', '#', ['class' => 'nav-link'])?>
                </li>
            </ul>
        </div>
    </div>
</div>