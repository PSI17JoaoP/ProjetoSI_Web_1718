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
            'enableSession' => false,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            //'name' => 'advanced-api',
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
                    'controller' => 'anuncios',
                    'extraPatterns' => [
                        'GET propostas/{username}' => 'todas-propostas',
                        'GET {id}/propostas' => 'propostas',
                        'GET {id}/categorias' => 'categorias',
                        'GET titulo/{titulo}' => 'pesquisa',
                        'GET titulo/{titulo}/regiao/{regiao}' => 'pesquisa',
                        'GET titulo/{titulo}/categoria/{categoria}' => 'pesquisa',
                        'GET titulo/{titulo}/regiao/{regiao}/categoria/{categoria}' => 'pesquisa',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{titulo}' => '<titulo:\\w+>',
                        '{regiao}' => '<regiao:\\w+>',
                        '{categoria}' => '<categoria:\\w+>',
                        '{username}' => '<username:\\w+>',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'categorias',
                    'extraPatterns' => [

                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'clientes',
                    'extraPatterns' => [
                        'GET pin/{pin}' => 'pin',
                        'GET {id}/categorias_preferidas' => 'preferidas'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{pin}' => '<pin:\\w+>',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'propostas',
                    'extraPatterns' => [
                        'GET {id}/categorias' => 'categorias'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'users',
                    'extraPatterns' => [
                        'GET {id}/username' => 'username',
                        'GET {id}/password' => 'password',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
