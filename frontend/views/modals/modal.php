<?php

/** @var $content string
 *  @var $options array
 *  @var $backdrop string
 *  @var $keyboard string
 *  @var $id string
 */

use yii\bootstrap\Modal;

Modal::begin([
    'header' => "<h4>".$header."</h4>",
    'id' => 'modal_geral',
    'size' => 'modal-md',
    'options' => [
        'data' => [
            'backdrop' => $backdrop,
            'keyboard' => $keyboard,
        ],
    ],
]); ?>

<div id='modalContent'>
    <?= $this->render($content, $options) ?>
</div>

<?php Modal::end() ?>