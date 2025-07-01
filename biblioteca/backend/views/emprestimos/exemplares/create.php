<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Exemplares $model */

$this->title = 'Create Exemplares';
$this->params['breadcrumbs'][] = ['label' => 'Exemplares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exemplares-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
