<?php
defined('YII_ENV')   or define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

$dbConfig = require __DIR__ . '/../../config/test_db.php';
(new yii\db\Connection($dbConfig))->open();
