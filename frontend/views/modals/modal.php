<?php

/** @var $content string
 *  @var $model mixed
 */

use yii\bootstrap\Modal;

Modal::begin([
    'header' => "<h4>".$header."</h4>",
    'id' => 'modal_geral',
    'size' => 'modal-md',
    'options' => [
        'data' => [
            'backdrop' => 'static',
            'keyboard' => 'false',
        ],
    ],
]); ?>

<div id='modalContent'>
    <?= $this->render($content, ['model' => $model]) ?>
</div>

<?php Modal::end() ?>