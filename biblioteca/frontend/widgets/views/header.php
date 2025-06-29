<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="flex items-center justify-between p-4">
    <div class="page-header-bar flex items-center gap-4">
        <h2 class="text-xl font-semibold text-white">
            <?= Html::encode($this->context->view->title ?: 'Dashboard') ?>
        </h2>
        <?= \yii\widgets\Breadcrumbs::widget([
            'homeLink' => ['label' => 'Início', 'url' => ['/site/index']],
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
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