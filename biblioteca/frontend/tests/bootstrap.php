<?php
defined('YII_ENV')   or define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

// 1) Autoload e núcleo do Yii
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
Yii::setAlias('@common', dirname(__DIR__, 2) . '/common');

// 2) Conexão ao DB de teste
$dbConfig = require __DIR__ . '/../../config/test_db.php';
$db = new yii\db\Connection($dbConfig);
$db->open();

// 3) Cria uma aplicação console mínima para registrar components
new yii\console\Application([
    'id'         => 'test-app',
    'basePath'   => dirname(__DIR__, 2),          // aponta para …/biblioteca
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'db' => $db,                              // registra Yii::$app->db
    ],
]);

// Agora Yii::$app e ActiveRecord encontram a conexão
