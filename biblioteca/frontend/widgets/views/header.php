<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="flex items-center justify-between p-4 bg-white shadow-sm">
    <div class="page-header-bar flex items-center gap-4">
        <h2 class="text-xl font-semibold page-title">
            <?= Html::encode($this->context->view->title ?: 'Dashboard') ?>
            <button id="sidebarToggle" class="text-2xl">☰</button>
            <button id="themeToggle" class="ml-2">🌙</button>
        </h2>

        <?= \yii\widgets\Breadcrumbs::widget([
            'homeLink' => ['label' => 'Início', 'url' => ['/site/index']],
            'links'    => $this->params['breadcrumbs'] ?? [],
            'options'  => ['class' => 'flex items-center text-sm text-gray-500'], 
            'itemTemplate' => '<li class="mx-2 select-none">/</li><li>{link}</li>',
            'activeItemTemplate' => '<li class="mx-2 select-none">/</li><li class="text-gray-800">{link}</li>',
        ]) ?>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'flex items-center']) ?>
        <?= Html::submitButton(
            'Logout (' . Html::encode(Yii::$app->user->identity->nome) . ')',
            ['class' => 'logout-btn']
        ) ?>
        <?= Html::endForm() ?>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar_toogle');
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