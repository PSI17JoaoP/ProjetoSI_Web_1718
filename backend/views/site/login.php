<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="col-6 col-md-4"></div>
    <div class="col-6 col-md-4">
        <div class="login-box" style="width: 100%">
            <div class="login-box-body">
                <div class="login-logo">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">

                        <?= Html::a('Esqueci-me da palavra-passe', ['login'], ['style' => ['margin-top' => '10px']]) ?>

                        <span class="pull-right">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button pull-right']) ?>
                        </span>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <div class="col-6 col-md-4"></div>
</div>
