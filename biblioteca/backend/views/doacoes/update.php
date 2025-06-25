<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Doacoes $model */

$this->title = 'Update Doacoes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Doacoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doacoes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
