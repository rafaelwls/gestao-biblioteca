<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Item_compras $model */

$this->title = 'Update Item Compras: ' . $model->compra_id;
$this->params['breadcrumbs'][] = ['label' => 'Item Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->compra_id, 'url' => ['view', 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-compras-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
