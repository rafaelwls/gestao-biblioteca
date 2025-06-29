<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Livros */

$this->title = 'Editando livro: ' . $model->titulo;
?>
<div class="form-container">
    <h1 class="text-2xl font-semibold mb-6"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['class' => '']]); ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'titulo', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'titulo')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'subtitulo', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'subtitulo')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'autor', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'autor')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'genero', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'genero')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'isbn', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'isbn')->textInput([ 'class' => 'form-input', 'readonly' => true, ])->label(false) ?>
    </div>


    <div class="form-group">
        <?= Html::activeLabel($model, 'ano_publicacao', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'ano_publicacao')->input('number', ['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'idioma', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'idioma')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'paginas', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'paginas')->input('number', ['class' => 'form-input'])->label(false) ?>
    </div>

    <div class="form-group flex space-x-4 mt-6">
        <?= Html::submitButton('Salvar', ['class' => 'form-button form-button-primary']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'form-button form-button-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>