<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoEmprestimo $model */

$this->title = 'Update Pedido Emprestimo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedido Emprestimos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pedido-emprestimo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
