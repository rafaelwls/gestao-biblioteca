<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DoacoesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="doacoes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'autor') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'data_solicitacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
