<?php

use yii\helpers\Html;

/* @var $model common\models\Livro */

$this->title = $model->titulo;
?>
<div class="bg-white p-6 rounded-lg shadow-sm max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4"><?= Html::encode($model->titulo) ?></h1>

    <p><strong>Autor:</strong> <?= Html::encode($model->autor) ?></p>
    <p><strong>Gênero:</strong> <?= Html::encode($model->genero) ?></p>
    <p><strong>ISBN:</strong> <?= Html::encode($model->isbn) ?></p>
    <p><strong>Status:</strong> <?= Html::encode($model->status) ?></p>

    <div class="mt-4 space-x-2">
        <?= Html::a(
            'Editar',
            ['update', 'id' => $model->id],
            ['class' => 'bg-primary text-white px-3 py-1 rounded']
        ) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'bg-red-600 text-white px-3 py-1 rounded',
            'data-confirm' => 'Remover este livro?',
            'data-method' => 'post'
        ]) ?>
    </div>
</div>
