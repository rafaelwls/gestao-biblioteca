<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\Livro */
?>

<div class="bg-white p-6 rounded-lg shadow-sm max-w-2xl">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'block font-medium mb-1'],
            'inputOptions' => ['class' => 'w-full border px-3 py-2 rounded-md'],
            'errorOptions' => ['class' => 'text-red-600 text-xs mt-1'],
        ],
    ]); ?>

    <?= $form->field($model, 'titulo') ?>
    <?= $form->field($model, 'autor') ?>
    <?= $form->field($model, 'genero') ?>
    <?= $form->field($model, 'isbn') ?>
    <?= $form->field($model, 'status')->dropDownList([
        'Disponível' => 'Disponível',
        'Emprestado' => 'Emprestado',
        'Vendido' => 'Vendido',
    ], ['class' => 'border px-3 py-2 rounded-md w-full']) ?>

    <div class="mt-4">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Salvar' : 'Atualizar',
            ['class' => 'bg-primary text-white px-4 py-2 rounded-md']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
