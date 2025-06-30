<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $livro common\models\Livros */
/* @var $compra common\models\Compras */
/* @var $quantidade int */
/* @var $valorUnitario float */

$this->title = 'Nova Compra: ' . $livro->titulo;  
?>
<div class="form-container max-w-3xl mx-auto p-6 bg-white shadow-sm rounded-lg">

    <h1 class="text-2xl font-semibold mb-6"><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="text-red-600 mb-4">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

        <!-- Informação do Livro (readonly) -->
        <div class="mb-4">
            <?= Html::label('Livro', null, ['class' => 'form-label']) ?>
            <?= Html::textInput('livro_titulo', $livro->titulo, [
                'class'    => 'form-input w-full',
                'readonly' => true,
            ]) ?>
        </div>

        <div class="mb-4">
            <?= Html::label('Quantidade de Exemplares', 'quantidade', ['class' => 'form-label']) ?>
            <?= Html::input('number', 'quantidade', $quantidade, [
                'class' => 'form-input w-full',
                'min'   => 1,
            ]) ?>
        </div>

        <div class="mb-4">
            <?= Html::label('Valor Unitário (R$)', 'valor_unitario', ['class' => 'form-label']) ?>
            <?= Html::input('text', 'valor_unitario', $valorUnitario, [
                'class' => 'form-input w-full',
                'placeholder' => '0.00',
            ]) ?>
        </div>

        <div class="flex space-x-4 mt-6">
            <?= Html::submitButton('Registrar Compra', [
                'class' => 'form-button form-button-primary'
            ]) ?>
            <?= Html::a('Cancelar', ['livros/view', 'id' => $livro->id], [
                'class' => 'form-button form-button-secondary'
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
