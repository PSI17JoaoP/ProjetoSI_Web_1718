<?php
use yii\helpers\Html;


dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<div class="col-xs-4">
    <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" width="85px" height="85px"  alt="User Image" />
</div>
<div class="col-xs-8">
    <h3 id="userProfileName" ></h3>
</div>

    