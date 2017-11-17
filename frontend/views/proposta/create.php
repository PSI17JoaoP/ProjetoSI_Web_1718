<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PropostaForm */
/* @var $listaCategorias array */
/* @var $anuncio integer */

$this->title = 'Enviar Proposta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proposta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'anuncio' => $anuncio,
        'listaCategorias' => $listaCategorias,
    ]) ?>

</div>
