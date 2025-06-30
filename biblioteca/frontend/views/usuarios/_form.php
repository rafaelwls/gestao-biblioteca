<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this     yii\web\View */
/* @var $model    common\models\Usuarios */
/* @var $form     yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'class'=>'form-input'])->label('Nome') ?>
    <?= $form->field($model, 'sobrenome')->textInput(['maxlength' => true, 'class'=>'form-input'])->label('Sobrenome') ?>
    <?= $form->field($model, 'email')->input('email', ['maxlength' => true, 'class'=>'form-input'])->label('E-mail') ?>
    <?= $form->field($model, 'data_validade')->input('date', ['class'=>'form-input'])->label('Data de Validade') ?>
    <?= $form->field($model, 'is_admin')->checkbox()->label('Administrador?') ?>
    <?= $form->field($model, 'is_trabalhador')->checkbox()->label('Trabalhador?') ?>

    <div class="mt-6 flex space-x-4">
        <?= Html::submitButton('Salvar', ['class' => 'form-button form-button-primary']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'form-button form-button-secondary']) ?>
    </div>

<?php ActiveForm::end(); ?>
