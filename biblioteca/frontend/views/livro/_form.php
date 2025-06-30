<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model    common\models\Livro */
/* @var $exemplar common\models\Exemplar */
?>

<div class="livro-form">
    <?php $form = ActiveForm::begin([
        'id'      => 'livro-form',
        'options' => ['class' => 'form-container'],
    ]); ?>

    <?= $form->errorSummary([$model, $exemplar]) ?>

    <!-- Campos do Livro -->
    <?= $form->field($model, 'titulo')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($model, 'autor')->textInput(['class'=>'form-input']) ?>
    <!-- … demais campos do Livro … -->

    <hr>
    <h4>Dados do Exemplar</h4>
    <?= $form->field($exemplar, 'status')->dropDownList([
        'Disponivel' => 'Disponível',
        'Emprestado'  => 'Emprestado',
        'Vendido'     => 'Vendido',
    ]) ?>
    <?= $form->field($exemplar, 'estado')->dropDownList([
        'novo' => 'Novo',
        'bom'  => 'Bom',
        'ruim' => 'Ruim',
    ]) ?>
    <?= $form->field($exemplar, 'codigo_barras')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($exemplar, 'data_aquisicao')->input('date') ?>

    <div class="mt-4">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Salvar' : 'Atualizar',
            ['class' => 'bg-primary text-white px-4 py-2 rounded-md']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
