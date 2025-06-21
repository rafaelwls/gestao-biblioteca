<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ItemVendasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="item-vendas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'venda_id') ?>

    <?= $form->field($model, 'exemplar_id') ?>

    <?= $form->field($model, 'valor_unitario') ?>

    <?= $form->field($model, 'quantidade') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
