<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\AnuncioForm */
/* @var $catList array */

$this->title = 'Criar Anúncio';
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anuncio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'catItems' => $catList,
    ]) ?>

</div>
