<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Item_vendas $model */

$this->title = 'Update Item Vendas: ' . $model->venda_id;
$this->params['breadcrumbs'][] = ['label' => 'Item Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->venda_id, 'url' => ['view', 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-vendas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
