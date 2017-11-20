<?php

/** @var $model common\models\Anuncio*/

use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',                                           // title attribute (in plain text)
        'description:html',                                // description attribute formatted as HTML
        [                                                  // the owner name of the model
            'label' => 'Owner',
            'value' => $model->owner->name,
            'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
            'captionOptions' => ['tooltip' => 'Tooltip'],  // HTML attributes to customize label tag
        ],
        'created_at:datetime',                             // creation date formatted as datetime
    ],
]);


