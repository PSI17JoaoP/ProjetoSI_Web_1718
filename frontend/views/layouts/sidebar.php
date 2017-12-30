<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;

?>


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
       
