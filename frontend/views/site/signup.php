<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4 col-md-3 align-self-start"></div>

            <div class="col-8 col-md-6 align-self-center">

                <?= Html::tag('h2', $this->title, ['style' => ['text-align' => 'center', 'margin-bottom' => '30px']])?>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'telefone') ?>

                <div class="form-group center-block">
                    <?= Html::submitButton('Criar Conta', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="col-4 col-md-3 align-self-end"></div>
        </div>
    </div>
</div>


<?php

// Código para o form sem utilizar o Active Form (Falta labels, logo apenas estaram inputs visivéis)
// REMINDER: Ver como fazer o input para validar a password (checkPassword) com active form

/*<?= Html::beginForm(['site/signup'], 'post', ['id' => 'form-signup'])
. Html::activeTextInput($model, 'username')
. Html::activepasswordInput($model, 'password')
. Html::passwordInput('checkPassword')
. Html::activeInput('email', $model, 'email')
. Html::activeTextInput($model, 'telefone')
. Html::submitButton('Criar Conta', ['class' => 'btn btn-primary', 'name' => 'signup-button'])
. Html::endForm() ?>*/

?>