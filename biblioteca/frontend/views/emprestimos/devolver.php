<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $emp common\models\Emprestimos */

$this->title = 'Devolver livro';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>
<p><strong>Livro:</strong> <?= Html::encode($emp->exemplar->livro->titulo) ?></p>

<?php $f = ActiveForm::begin(); ?>
<?= $f->field($form, 'data_devolucao_real')
    ->input('date', ['value' => date('Y-m-d')]) ?>
<button class="bg-primary text-white px-4 py-2 rounded">Confirmar</button>
<?php ActiveForm::end(); ?>
