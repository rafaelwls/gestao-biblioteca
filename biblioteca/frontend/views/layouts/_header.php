<?php

use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <span class="navbar-brand">Olá, <?= Html::encode($user->nome) ?></span>
        <div class="ms-auto">
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
            <?= Html::submitButton('Logout', ['class' => 'btn btn-link']) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</nav>
