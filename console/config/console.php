<?php
$db = require __DIR__ . '/db.php';
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => ['log','queues'],
    'components' => [
        'queues' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        // 'dbOld'=> $db['db2'],
    ],


    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'message' => [
            'class' => console\controllers\ExtendedMessageController::class
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class' => console\controllers\RbacMigrateController::class,
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
    ],
];
