<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


Modal::begin([
    'header'=>'<h4>Adicionar informações de conta</h4>',
    'id'=>'modal_geral',
    'size'=>'modal-md',
 ]);

?>

    <div id='modalContent'>

    <?= $this->render($content, ['model' => $model]); ?>

    </div>
<?php
Modal::end();
?>