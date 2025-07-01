<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Exemplares $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="exemplares-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'livro_id')->textInput() ?>

    <?= $form->field($model, 'data_aquisicao')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo_barras')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_remocao')->textInput() ?>

    <?= $form->field($model, 'motivo_remocao')->dropDownList([ 'DANIFICADO' => 'DANIFICADO', 'DESATUALIZADO' => 'DESATUALIZADO', 'OUTRO' => 'OUTRO', 'PERDIDO' => 'PERDIDO', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
