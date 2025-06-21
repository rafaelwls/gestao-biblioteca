<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fluxo_pessoas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fluxo-pessoas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'ENTRADA' => 'ENTRADA', 'SAIDA' => 'SAIDA', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
