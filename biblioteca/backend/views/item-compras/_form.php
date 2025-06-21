<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Item_compras $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="item-compras-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'compra_id')->textInput() ?>

    <?= $form->field($model, 'exemplar_id')->textInput() ?>

    <?= $form->field($model, 'valor_unitario')->textInput() ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
