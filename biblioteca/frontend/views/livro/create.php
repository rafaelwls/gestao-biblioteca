<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Livro */

$this->title = 'Criando um novo Livro';
?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="text-red-600 mb-4">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>


<div class="form-container">
    

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-md">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                <?= Html::encode($this->title) ?>
            </h3>
        </div>

        <div class="px-6 py-4">
            <?= $this->render('_form', [
                'model'    => $model,
                'exemplar' => $exemplar,
            ]) ?>
        </div>
    </div>
</div>
