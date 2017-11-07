<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Proposta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Propostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat_proposto',
            'quant',
            'id_user',
            'id_anuncio',
            'estado',
            'data_proposta',
        ],
    ]) ?>

</div>
