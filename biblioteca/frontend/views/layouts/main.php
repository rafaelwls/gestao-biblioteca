<?php
/* fronted/views/layouts/main.php */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.6/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="h-screen flex bg-gray-50">
    <?php $this->beginBody() ?>

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r overflow-auto">
        <?= \frontend\widgets\SidebarWidget::widget() ?>
    </aside>

    <!-- Conteúdo principal (header + views) -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b">
            <?= \frontend\widgets\HeaderWidget::widget() ?>
        </header>

        <!-- Body -->
        <main class="flex-1 overflow-auto p-6">
            <?= $content ?>
        </main>
    </div>

    <?php $this->endBody() ?>
</body>
 
</html>
<?php $this->endPage() ?>
