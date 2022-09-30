<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=docker_mysql;dbname=yii2-starter-kit',
    'username' => 'root',
    'password' => 'zyz123',
    'charset' => 'utf8',
//    'class' => 'yii\redis\Connection',
//    'hostname' => 'docker_redis',
//    'port' => 6379,
//    'database' => 0,

//    'db1'=>[
//        'class' => 'yii\db\Connection',
//        'dsn' => 'mysql:host=docker_mysql;dbname=yii2-starter-kit',
//        'username' => 'root',
//        'password' => 'zyz123',
//        'charset' => 'utf8',
//    ],
//    'db2'=>[
//        'class' => 'yii\redis\Connection',
//        'hostname' => 'docker_redis',
//        'port' => 6379,
//        'database' => 0,
//
//    ],

    /*  'db1'=>[
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=all',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    ],
    'db2'=>[
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=all-india',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    ] */


    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];