<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="flex items-center justify-between p-4">
    <div class="flex items-center gap-4">
        <!-- botão de colapsar sidebar (se quiser JS) -->
        <button id="sidebarToggle" class="text-2xl">☰</button>
        <h2 class="text-xl font-semibold"><?= Html::encode($this->context->view->title ?: 'Dashboard') ?></h2>
    </div>

    <div>
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Login', ['/site/login'], ['class' => 'text-blue-600 hover:underline']) ?>
        <?php else: ?>
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'inline']) ?>
            <?= Html::submitButton(
                'Logout (' . Html::encode(Yii::$app->user->identity->nome) . ')',
                ['class' => 'text-red-600 hover:underline']
            ) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </div>
</div>
