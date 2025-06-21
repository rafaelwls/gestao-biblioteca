<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Item_vendas $model */

$this->title = $model->venda_id;
$this->params['breadcrumbs'][] = ['label' => 'Item Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-vendas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id], [
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
            'venda_id',
            'exemplar_id',
            'valor_unitario',
            'quantidade',
        ],
    ]) ?>

</div>
