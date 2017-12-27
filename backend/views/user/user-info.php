<?php
use yii\helpers\Html;


dmstr\web\AdminLteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<div class="col-xs-4">
    <img src="" width="85px" height="85px"  alt="" id="userImage" />
</div>
<div class="col-xs-8">
    <h3 id="userProfileName" ></h3>
    <p id="userEmail"></p>
    <p id="userTelefone"></p>
    <p id="userRegiao"></p>
</div>
<div class="col-xs-12">
    <div class="panel">
        <div class="panel-heading">
            <strong>Anúncios</strong>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td><b>Título</b></td>
                        <td><b>Troca</b></td>
                        <td><b>Por</b></td>
                        <td><b>Nº Propostas</b></td>
                    </tr>
                </thead>
                <tbody id="userAnuncios">
                </tbody>
            </table>
        </div>
    </div>
</div>
    