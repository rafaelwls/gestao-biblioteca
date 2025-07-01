<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\EmprestimosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="emprestimos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'exemplar_id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'data_emprestimo') ?>

    <?= $form->field($model, 'data_devolucao_prevista') ?>

    <?php // echo $form->field($model, 'data_devolucao_real') ?>

    <?php // echo $form->field($model, 'multa_calculada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
