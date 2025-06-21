<?php

use common\models\Item_vendas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ItemVendasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Item Vendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-vendas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Item Vendas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'venda_id',
            'exemplar_id',
            'valor_unitario',
            'quantidade',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Item_vendas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'venda_id' => $model->venda_id, 'exemplar_id' => $model->exemplar_id]);
                 }
            ],
        ],
    ]); ?>


</div>
