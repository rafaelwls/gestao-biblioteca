<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Livro */

$this->title = 'Novo Livro';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model]) ?>
