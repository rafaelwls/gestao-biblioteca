<?php

use yii\helpers\Html;

$this->title = 'Editar Venda';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', compact('model', 'items')) ?>
