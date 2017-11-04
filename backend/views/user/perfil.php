<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


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
                        <?php $form = ActiveForm::begin(['id' => 'perfil-form']); ?>

                        <?= $form->field($model, 'username')->textInput() ?>
                       
                        <?= $form->field($model, 'email')->input('email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>
                        
                        <span class="pull-right">
                            <?= Html::submitButton('Concluído', ['class' => 'btn btn-primary btn-lg', 'name' => 'perfil-button pull-right']) ?>
                        </span>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>