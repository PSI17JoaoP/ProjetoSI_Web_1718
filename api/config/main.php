<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'anuncios'
                    
                ],
                [
                    
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'categorias'
                    
                ],
                [
                    
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'clientes'
                    
                ],
                [
                    
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'propostas'
                    
                ],
                [
                    
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'users'
                    
                ],
            ],
        ],
        
    ],
    'params' => $params,
];