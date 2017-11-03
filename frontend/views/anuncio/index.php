<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AnuncioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anuncios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anuncio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Anuncio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'id_user',
            'cat_oferecer',
            'quant_oferecer',
            // 'cat_receber',
            // 'quant_receber',
            // 'estado',
            // 'data_criacao',
            // 'data_conclusao',
            // 'comentarios',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
