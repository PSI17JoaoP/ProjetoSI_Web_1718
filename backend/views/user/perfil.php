<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Gestão de Utilizadores';
dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center"><?= Yii::$app->user->identity->username ?></h3>

                        <p class="text-muted text-center">Administrador</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                            <b>Email:</b> <a class="pull-right"><?= Yii::$app->user->identity->email ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Editar dados pessoais</h3>
                    </div>
                    <div class="box-body">
                        <label for="nomeAdmin">Nome:</label>
                        <input type="text" class="form-control" id="nomeAdmin" value="<?= Yii::$app->user->identity->username ?>">

                        <label for="emailAdmin">Email:</label>
                        <input type="email" class="form-control" id="emailAdmin" value="<?= Yii::$app->user->identity->email ?>">

                        <label for="passAdmin">Nova palavra-passe</label>
                        <input type="password" class="form-control" id="passAdmin">

                        <button class="btn btn-default btn-lg">Concluído</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>