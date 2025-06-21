<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ExemplaresSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="exemplares-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'livro_id') ?>

    <?= $form->field($model, 'data_aquisicao') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'codigo_barras') ?>

    <?php // echo $form->field($model, 'data_remocao') ?>

    <?php // echo $form->field($model, 'motivo_remocao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
