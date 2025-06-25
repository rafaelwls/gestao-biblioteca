<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Doacoes $model */

$this->title = 'Create Doacoes';
$this->params['breadcrumbs'][] = ['label' => 'Doacoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doacoes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
