<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoEmprestimo $model */

$this->title = 'Create Pedido Emprestimo';
$this->params['breadcrumbs'][] = ['label' => 'Pedido Emprestimos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-emprestimo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
