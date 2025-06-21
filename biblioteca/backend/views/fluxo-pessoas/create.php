<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fluxo_pessoas $model */

$this->title = 'Create Fluxo Pessoas';
$this->params['breadcrumbs'][] = ['label' => 'Fluxo Pessoas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fluxo-pessoas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
