<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Item_compras $model */

$this->title = 'Create Item Compras';
$this->params['breadcrumbs'][] = ['label' => 'Item Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-compras-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
