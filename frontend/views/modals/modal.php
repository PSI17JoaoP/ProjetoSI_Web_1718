<?php

/** @var $content string
 *  @var $model mixed
 *  @var $backdrop string
 *  @var $keyboard string
 *  @var $id string
 */

use yii\bootstrap\Modal;

Modal::begin([
    'header' => "<h4>".$header."</h4>",
    'id' => $id,
    'size' => 'modal-md',
    'options' => [
        'data' => [
            'backdrop' => $backdrop,
            'keyboard' => $keyboard,
        ],
    ],
]); ?>

<div id='modalContent'>
    <?= $this->render($content, ['model' => $model]) ?>
</div>

<?php Modal::end() ?>