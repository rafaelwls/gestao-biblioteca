<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Item_compras $model */

$this->title = $model->compra_id;
$this->params['breadcrumbs'][] = ['label' => 'Item Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-compras-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'compra_id',
            'exemplar_id',
            'valor_unitario',
            'quantidade',
        ],
    ]) ?>

</div>
