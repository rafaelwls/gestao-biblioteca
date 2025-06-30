<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model common\models\Livro */
?>

<div class="livro-form">
    <?php $form = ActiveForm::begin([
        'id' => 'livro-form',
        'options' => ['class' => 'form-container'],
    ]); ?>

    <?= $form->errorSummary($model) // mostra aqui todos os erros ?>  
    
    <?= $form->field($model, 'titulo')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($model, 'autor')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($model, 'genero')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($model, 'isbn')->textInput(['class'=>'form-input']) ?>
    <?= $form->field($model, 'status')->dropDownList([
        'Disponivel' => 'Disponivel',
        'Emprestado'  => 'Emprestado',
        'Vendido'     => 'Vendido',
    ], ['class'=>'form-input']) ?>

    <div class="mt-4">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Salvar' : 'Atualizar',
            ['class' => 'bg-primary text-white px-4 py-2 rounded-md']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
