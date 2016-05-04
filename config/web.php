<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'markaua',
    'name' => 'lounge store markaua',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\module\admin\AdminModule',
        ],
    ],


    'components' => [

        'cart' => [
            'class' => 'app\ShoppingCart',
            'cartId' => 'my_application_cart',
        ],


        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JustTesty',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                'cart/<action>' => 'cart/<action>',
                'brands/<action>' => 'brands/<action>',
                'materialproduct/<action>' => 'materialproduct/<action>',
                'logout' => 'site/logout',
                'login' => 'site/login',
                '<genus:\w+>/<action>' => 'product/<action>',
                '<controller>/<action>' => '<controller>/<action>',
                //'<controller>/<action>' => '<controller>/<action>',
            ],
            // ...
        ],


        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
  'allowedIPs' => ['*'] 
 ];
}

return $config;
