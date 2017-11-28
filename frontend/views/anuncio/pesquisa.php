<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AnuncioSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="anuncio-search">

<?php

        foreach($anuncios as $anuncio) {

            if($anuncio !== null) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="margin-top: 8px; margin-left: 5px"><?= Html::encode($anuncio->titulo) ?></p>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            <?= Html::a('Detalhes', '#', ['class' => 'btn btn-primary showModal'])?>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php /*echo $this->renderAjax('//modals/modal',[
                            'header' => $anuncio->titulo,
                            'model' => $anuncio,
                            'content' => '//modals/anuncio'])*/ ?>

            <?php } ?>
        <?php } ?>

</div>