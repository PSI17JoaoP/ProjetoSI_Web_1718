<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\rating\StarRating;


?>
<div class="pesquisa_loading_modal" align="center" style="display:none">
    <img src="../../web/assets/loading.gif"/>
</div>
<div class="modal_detalhes">
</div>

<div class="modal_rating">
    <label for="#rate">Sua pontuação:</label>
    <?= StarRating::widget([
        'id' => 'rate',
        'class' => 'rating',
        'name' => 'rating',
        'pluginOptions' => [
            'disabled'=>false, 
            'showClear'=>false,
            'step' => 0.1,
            'size'=>'xs',
            'showCaption' => false,
        ]
    ]); ?>
     <?= Html::a('Avaliar', 'javascript:', [
        'id' => 'btn-rate',
        'class' => 'btn btn-primary btn-sm', 
        'data-detail' => Url::toRoute(['user/avaliar'])])?>
</div>

