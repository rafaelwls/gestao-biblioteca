<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fluxo_pessoas $model */

$this->title = 'Update Fluxo Pessoas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fluxo Pessoas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fluxo-pessoas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
