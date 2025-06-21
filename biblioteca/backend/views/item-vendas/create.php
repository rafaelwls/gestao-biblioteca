<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Item_vendas $model */

$this->title = 'Create Item Vendas';
$this->params['breadcrumbs'][] = ['label' => 'Item Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-vendas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
