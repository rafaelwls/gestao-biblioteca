<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UsuariosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'sobrenome') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'data_cadastro') ?>

    <?php // echo $form->field($model, 'data_validade') ?>

    <?php // echo $form->field($model, 'is_admin')->checkbox() ?>

    <?php // echo $form->field($model, 'is_trabalhador')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
