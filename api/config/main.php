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
                        'GET sugeridos/{username}' => 'sugeridos',
                        'GET {id}/propostas' => 'propostas',
                        'GET {id}/categoriaOferecer' => 'categorias-o',
                        'GET {id}/categoriaReceber' => 'categorias-r',
                        'GET titulo/{titulo}' => 'pesquisa',
                        'GET regiao/{regiao}' => 'pesquisa',
                        'GET categoria/{categoria}' => 'pesquisa',
                        'GET regiao/{regiao}/categoria/{categoria}' => 'pesquisa',
                        'GET titulo/{titulo}/regiao/{regiao}' => 'pesquisa',
                        'GET titulo/{titulo}/categoria/{categoria}' => 'pesquisa',
                        'GET titulo/{titulo}/regiao/{regiao}/categoria/{categoria}' => 'pesquisa',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{titulo}' => '<titulo:[\\w\s]+>',
                        '{regiao}' => '<regiao:\\w+>',
                        '{categoria}' => '<categoria:\\w+>',
                        '{username}' => '<username:[\\w\s]+>',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'categorias',
                    'extraPatterns' => [
                        'GET generos' => 'generos',
                        'GET tipos' => 'tipos',
                        'POST /' => 'criar',
                        'DELETE {id}' => 'apagar',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'clientes',
                    'extraPatterns' => [
                        'GET {id}/anuncios' => 'anuncios',
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
                ],
            ],
        ],
    ],
    'params' => $params,
];
