<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model    common\models\Livros */
/* @var $exemplar common\models\Exemplares */
?>

<div class="livro-form">
    <?php $form = ActiveForm::begin([
        'id'      => 'livro-form',
        'options' => ['class' => 'form-container'],
    ]); ?>

    <?= $form->errorSummary([$model, $exemplar]) ?>

    <!-- campos do Livro -->
    <?= $form->field($model, 'titulo')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($model, 'autor')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($model, 'genero')->textInput(['class' => 'form-input']) ?>

    <!-- novos campos -->
    <?= $form->field($model, 'subtitulo')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($model, 'ano_publicacao')->input('number', [
        'min'   => 0,
        'class' => 'form-input',
    ]) ?>
    <?= $form->field($model, 'idioma')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($model, 'paginas')->input('number', [
        'min'   => 1,
        'class' => 'form-input',
    ]) ?>

    <?= $form->field($model, 'isbn')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($model, 'status')->dropDownList([
        'Disponivel' => 'Disponível',
        'Emprestado'  => 'Emprestado',
        'Vendido'     => 'Vendido',
    ], ['class' => 'form-input']) ?>

    <hr>
    <h4 class="mt-6 mb-2 text-lg font-semibold">Dados do Exemplar</h4>

    <?= $form->field($exemplar, 'quantidade')->input('number', [
        'min'   => 1,
        'class' => 'form-input',
    ]) ?>

    <?= $form->field($exemplar, 'estado')->dropDownList([
        'novo' => 'Novo',
        'bom'  => 'Bom',
        'ruim' => 'Ruim',
    ], ['class' => 'form-input']) ?>

    <?= $form->field($exemplar, 'codigo_barras')->textInput(['class' => 'form-input']) ?>
    <?= $form->field($exemplar, 'data_aquisicao')->input('date', ['class' => 'form-input']) ?>

    <div class="mt-6">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Salvar' : 'Atualizar',
            ['class' => 'bg-primary text-white px-4 py-2 rounded-md']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
