<?php

use frontend\assets\BiblioAsset;
use yii\helpers\Html;

BiblioAsset::register($this);
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | BiblioTech</title>
    <?php $this->head() ?>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php $this->beginBody() ?>

    <?= $this->render('_sidebar', compact('user')) ?>

    <header class="fixed left-60 right-0 top-0 h-14 bg-white border-b flex items-center px-6 z-30">
        <form class="relative mr-auto w-64">
            <input class="pl-8 pr-3 py-2 w-full rounded-md border text-sm placeholder-gray-400"
                placeholder="Buscar…">
            <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </form>
        <div class="flex items-center space-x-5">
            <!-- sininho -->
            <a class="relative text-gray-500 hover:text-gray-700" href="#">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6
                       0 00-5-5.917V4a2 2 0 10-4 0v1.083A6 6 0 004 11v3.159c0
                       .538-.214 1.055-.595 1.436L2 17h5m5 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px]
                         w-4 h-4 grid place-items-center rounded-full">2</span>
            </a>
            <!-- avatar genérico -->
            <svg class="w-7 h-7 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0
                     1114 0H5z" clip-rule="evenodd" />
            </svg>
        </div>
    </header>

    <main class="ml-60 pt-16 p-6">
        <?= $content ?>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
