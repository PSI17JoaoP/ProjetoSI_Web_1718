<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render('topbar',['notificacoes' => $this->params['notifications']]) ?>

<div class="wrap">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <nav class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('sidebar') ?>
        </nav>
        <section class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
            <?= $content ?>
        </section>
    </div>
</div>

<?= $this->render('footbar'); ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
