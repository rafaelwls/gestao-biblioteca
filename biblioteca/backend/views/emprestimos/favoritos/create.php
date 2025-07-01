<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Favoritos $model */

$this->title = 'Create Favoritos';
$this->params['breadcrumbs'][] = ['label' => 'Favoritos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favoritos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
