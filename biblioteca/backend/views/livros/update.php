<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Livros $model */

$this->title = 'Update Livros: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Livros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="livros-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
