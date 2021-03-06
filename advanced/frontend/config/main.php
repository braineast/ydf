<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'user/login',
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
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:dbname=mobile;host=127.0.0.1',
            'username' =>'mobile',
            'password' => 'sql_1qaz2wsx',
            'charset' => 'utf8'
        ],
        'ydf_db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:dbname=xindai;host=127.0.0.1',
            'username' =>'xindai',
            'password' => 'sql_1qaz2wsx',
            'charset' => 'utf8'
        ],
    ],
    'params' => $params,
];
