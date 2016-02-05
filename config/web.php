<?php
$config = [
    'id' => 'basic',
    'basePath' => '/var/www/html',
    'vendorPath' => '/var/www/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\ApcCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => \DockerEnv::dbDsn(),
            'username' => \DockerEnv::dbUser(),
            'password' => \DockerEnv::dbPassword(),
            'charset' => 'utf8',
            'tablePrefix' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => \DockerEnv::get('SMTP_HOST'),
                'username' => \DockerEnv::get('SMTP_USER'),
                'password' => \DockerEnv::get('SMTP_PASSWORD'),
            ],
        ],
        'log' => [
            'traceLevel' => \DockerEnv::get('YII_TRACELEVEL', 0),
            'targets' => [
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stdout',
                    'levels' => ['info','trace'],
                    'logVars' => [],
                ],
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stderr',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => \DockerEnv::get('COOKIE_VALIDATION_KEY', null, !YII_ENV_TEST),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules'=>array(
                [
                    'class' => 'yii\rest\UrlRule',          //makes all rests routes for ingredients
                    'controller' => 'api/ingredient',
                    'extraPatterns' =>
                    [
                        'GET <id>/relationships/pizza' => 'view-link-pizza',
                        'POST <id>/relationships/pizza' => 'create-link-pizza',
                        'PATCH <id>/relationships/pizza' => 'update-link-pizza',
                        'DELETE <id>/relationships/pizza' => 'delete-link-pizza'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',         //makes all rests routes for pizzas
                    'controller' => 'api/pizza',
                    'extraPatterns' =>
                    [
                        'GET <id>/relationships/ingredient' => 'view-link-ingredient',
                        'POST <id>/relationships/ingredient' => 'create-link-ingredient',
                        'PATCH <id>/relationships/ingredient' => 'update-link-ingredient',
                        'DELETE <id>/relationships/ingredient' => 'delete-link-ingredient'
                    ],
                ],
            ),
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
    ],
    'params' => require('/var/www/html/config/params.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
