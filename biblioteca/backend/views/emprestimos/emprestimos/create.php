<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Emprestimos $model */

$this->title = 'Create Emprestimos';
$this->params['breadcrumbs'][] = ['label' => 'Emprestimos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emprestimos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
