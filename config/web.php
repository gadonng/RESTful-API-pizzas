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
                ['class' => 'yii\rest\UrlRule',      //makes all rests routes
                'controller' => 'ingredients'],      //for ingredients
                ['class' => 'yii\rest\UrlRule',      //and
                'controller' => 'pizzas']            //for pizzas calling respectively IngredientsController and PizzasController
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
