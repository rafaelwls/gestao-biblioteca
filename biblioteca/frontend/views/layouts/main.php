<?php
/* frontend/views/layouts/main.php */

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
    <!-- Layout CSS estático -->
    <style>

    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const btnSidebar = document.getElementById('sidebarToggle');
        const btnTheme = document.getElementById('themeToggle');
        const app = document.getElementById('app');

        // Inicializa tema  
        const saved = localStorage.getItem('theme') || 'light';
        app.setAttribute('data-theme', saved);
        btnTheme.textContent = saved === 'light' ? '🌙' : '☀️';

        // Toggle sidebar
        btnSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('hidden-sidebar');
        });

        // Toggle theme
        btnTheme.addEventListener('click', () => {
            const current = app.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            app.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            btnTheme.textContent = next === 'light' ? '🌙' : '☀️';
        });
    }); 
</script>

<body id="app" data-theme="light">
    <?php $this->beginBody() ?>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-60 bg-white border-r z-40">
        <div class="sidebar-header p-4">
            <h1 class="text-xl font-bold">BiblioTech</h1>
            <p class="text-sm text-gray-500">Sistema de Biblioteca</p>
        </div>
        <?= \frontend\widgets\SidebarWidget::widget() ?>
    </aside>

    <!-- Conteúdo principal -->
    <div class="main-wrapper flex-1 flex flex-col">
        <header>
            <?= \frontend\widgets\HeaderWidget::widget() ?>
            <button id="sidebarToggle" class="text-2xl">☰</button>
            <button id="themeToggle" class="ml-2">🌙</button>
        </header>
        <main>
            <?= $content ?>
        </main>
    </div>

    <?php $this->endBody() ?>
</body>
 
</html>
<?php $this->endPage() ?>