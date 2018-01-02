<?php
use yii\helpers\Html;
use yii\helpers\Url;


dmstr\web\AdminLteAsset::register($this);

?>

<div class="col-xs-4">
    <img src="../../web/assets/pic_placeholder.png" width="85px" height="85px"  alt="" id="userImage" />
</div>
<div class="col-xs-8">
    <h3 id="userProfileName" ></h3>
    <p id="userEmail"></p>
    <p id="userTelefone"></p>
    <p id="userRegiao"></p>
    <button id="userStatus" class="btn btn-warning btn-sm">Bloquear</button>
    <span id="userStatusOpt" style="display:none">
    Tem a certeza ?
        <a id="userStatusSim" class="btn btn-danger btn-sm" data-href="<?= Url::toRoute(['user/mudar-status'])?>">Sim</a>
        <button id="userStatusNao" class="btn btn-success btn-sm">Não</button>
    </span>
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
    