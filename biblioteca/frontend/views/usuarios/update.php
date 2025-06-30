<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Usuarios */

$this->title = 'Editando usuário: ' . $model->nome . ' ' . $model->sobrenome;
$this->params['breadcrumbs'][] = ['label' => 'Todos os Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome . ' ' . $model->sobrenome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="form-container max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-sm">

    <h1 class="text-2xl font-semibold mb-6"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Nome -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'nome', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'nome')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <!-- Sobrenome -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'sobrenome', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'sobrenome')->textInput(['class' => 'form-input'])->label(false) ?>
    </div>

    <!-- E-mail -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'email', ['class' => 'form-label']) ?>
        <?= $form->field($model, attribute: 'email')->input('email', ['class' => 'form-input'])->label(false) ?>
    </div>

    <!-- Data de Validade -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'data_validade', ['class' => 'form-label']) ?>
        <?= $form->field($model, 'data_validade')->input('date', ['class' => 'form-input'])->label(false) ?>
    </div>

    <!-- is_admin -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'is_admin', ['class' => 'form-label block']) ?>
        <?= $form->field($model, 'is_admin')->checkbox()->label(false) ?>
    </div>

    <!-- is_trabalhador -->
    <div class="form-group mb-4">
        <?= Html::activeLabel($model, 'is_trabalhador', ['class' => 'form-label block']) ?>
        <?= $form->field($model, 'is_trabalhador')->checkbox()->label(false) ?>
    </div>

    <!-- Botões -->
    <div class="form-group flex space-x-4 mt-6">
        <?= Html::submitButton('Salvar', [
            'class' => 'form-button form-button-primary'
        ]) ?>
        <?= Html::a('Cancelar', ['view', 'id' => $model->id], [
            'class' => 'form-button form-button-secondary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
