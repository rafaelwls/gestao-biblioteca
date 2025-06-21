<?php

use common\models\Item_compras;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ItemComprasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Item Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-compras-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Item Compras', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'compra_id',
            'exemplar_id',
            'valor_unitario',
            'quantidade',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Item_compras $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'compra_id' => $model->compra_id, 'exemplar_id' => $model->exemplar_id]);
                 }
            ],
        ],
    ]); ?>


</div>
