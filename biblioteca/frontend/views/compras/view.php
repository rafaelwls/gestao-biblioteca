<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Compras */

$this->title = 'Detalhes da Compra'; 
?>
<div class="compras-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Ações dependendo do perfil -->
    <div class="mt-4 mb-6 flex space-x-2">
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_trabalhador && $model->status === 'PENDENTE'): ?>
            <?= Html::a('Aprovar', ['approve', 'id' => $model->id], [
                'class' => 'form-button form-button-primary',
                'data-method' => 'post',
            ]) ?>
            <?= Html::a('Rejeitar', ['reject', 'id' => $model->id], [
                'class' => 'form-button form-button-secondary',
                'data-method' => 'post',
            ]) ?>
        <?php endif; ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'form-button']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Livro',
                'value' => function($m) { return $m->exemplar->livro->titulo; },
            ],
            [
                'label' => 'Código de Barras',
                'value' => 'exemplar.codigo_barras',
            ],
            'quantidade',
            [
                'attribute' => 'valor_unitario',
                'format' => ['currency','BRL'],
            ],
            [
                'attribute' => 'valor_total',
                'format' => ['currency','BRL'],
            ],
            'status',
            'data_compra:date',
        ],
    ]) ?>
</div>
