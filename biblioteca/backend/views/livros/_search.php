<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\LivrosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="livros-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'subtitulo') ?>

    <?= $form->field($model, 'ano_publicacao') ?>

    <?php // echo $form->field($model, 'idioma') ?>

    <?php // echo $form->field($model, 'paginas') ?>

    <?php // echo $form->field($model, 'data_criacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
