<?php
//$config = [
//    'homeUrl' => Yii::getAlias('@backendUrl'),
//    'controllerNamespace' => 'backend\controllers',
//    'defaultRoute' => 'timeline-event/index',
//    'timeZone' => 'Asia/Ho_Chi_Minh',
//    'components' => [
//        'redis' => [
//            'class' => 'yii\redis\Connection',
//            'hostname' => 'docker_redis',
//            'port' => 6378,
//            'database' => 0,
//        ],
//
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
//        'request' => [
//            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
//            'baseUrl' => env('BACKEND_BASE_URL'),
////            'parsers' => [
////                'application/json' => 'yii\web\JsonParser',
////            ]
//        ],
//        'user' => [
//            'class' => yii\web\User::class,
//            'identityClass' => common\models\User::class,
//            'loginUrl' => ['sign-in/login'],
////            'loginUrl' => ['users'],
//            'enableAutoLogin' => true,
//            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class,
//        ],
//
//    ],
//    'modules' => [
//        'content' => [
//            'class' => backend\modules\content\Module::class,
//        ],
//        'widget' => [
//            'class' => backend\modules\widget\Module::class,
//        ],
//        'file' => [
//            'class' => backend\modules\file\Module::class,
//        ],
//        'system' => [
//            'class' => backend\modules\system\Module::class,
//        ],
//        'translation' => [
//            'class' => backend\modules\translation\Module::class,
//        ],
//        'rbac' => [
//            'class' => backend\modules\rbac\Module::class,
//            'defaultRoute' => 'rbac-auth-item/index',
//        ],
//    ],
//    'as globalAccess' => [
//        'class' => common\behaviors\GlobalAccessBehavior::class,
//        'rules' => [
//            [
//                'controllers' => ['sign-in'],
//                'allow' => true,
//                'roles' => ['?'],
//                'actions' => ['login'],
//            ],
//            [
//                'controllers' => ['sign-in'],
//                'allow' => true,
//                'roles' => ['@'],
//                'actions' => ['logout'],
//            ],
//            [
//                'controllers' => ['site'],
//                'allow' => true,
//                'roles' => ['?', '@'],
//                'actions' => ['error'],
//            ],
//            [
//                'controllers' => ['debug/default'],
//                'allow' => true,
//                'roles' => ['?'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => true,
//                'roles' => ['administrator'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => false,
//            ],
////            [
////                'controllers' => ['book'],
////                'allow' => true,
////
////            ],
//            [
//                'allow' => true,
//                'roles' => ['manager', 'administrator'],
//            ],
//        ],
//    ],
//];
//
//if (YII_ENV_DEV) {
//    $config['modules']['gii'] = [
//        'class' => yii\gii\Module::class,
//        'generators' => [
//            'crud' => [
//                'class' => yii\gii\generators\crud\Generator::class,
//                'templates' => [
//                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates'),
//                ],
//                'template' => 'yii2-starter-kit',
//                'messageCategory' => 'backend',
//            ],
//        ],
//    ];
//}
//
//return $config;

$db = require __DIR__ . '/db.php';

$config = [
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'timeline-event/index',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'bootstrap' => [
        'queues', // The component registers its own console commands
//        'queues', // The component registers its own console commands
    ],
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'docker_redis',
            'port' => 6379,
            'database' => 0,
        ],
//        'queues' => [
//            'class' => 	\yii\queue\amqp_interop\Queue::class,
////            'hostname' => 'docker_rabbitmq',
//            'port' => 5672,
//            'user' => 'guest',
//            'password' => 'guest',
//            'queueName' => 'queue',
//            'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
//
//            // or
////            'dsn' => 'amqp://guest:guest@localhost:5672/%2F',
//
//            // or, same as above
//            'dsn' => 'amqp:',
//
        'queues' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => env('BACKEND_BASE_URL'),
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class,
        ],
    ],

    'modules' => [
        'content' => [
            'class' => backend\modules\content\Module::class,
        ],
        'widget' => [
            'class' => backend\modules\widget\Module::class,
        ],
        'file' => [
            'class' => backend\modules\file\Module::class,
        ],
        'system' => [
            'class' => backend\modules\system\Module::class,
        ],
        'translation' => [
            'class' => backend\modules\translation\Module::class,
        ],
        'rbac' => [
            'class' => backend\modules\rbac\Module::class,
            'defaultRoute' => 'rbac-auth-item/index',
        ],
    ],
    'as globalAccess' => [
        'class' => common\behaviors\GlobalAccessBehavior::class,
        'rules' => [
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['login'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions' => ['logout'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['error'],
            ],
            [
                'controllers' => ['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers' => ['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers' => ['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager', 'administrator'],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'templates' => [
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates'),
                ],
                'template' => 'yii2-starter-kit',
                'messageCategory' => 'backend',
            ],
        ],
    ];
}

return $config;