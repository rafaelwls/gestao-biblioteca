<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Vendas $model */

$this->title = 'Create Vendas';
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
