<?php

use yii\helpers\Html;

/* @var $model common\models\Compras */

$this->title = 'Pedido ' . substr($model->id, 0, 6);
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="bg-white rounded-lg p-6 shadow-sm">
    <p><strong>Data:</strong> <?= Yii::$app->formatter->asDate($model->data_compra) ?></p>
    <p><strong>Usuário:</strong> <?= Html::encode($model->usuario->nome ?? '-') ?></p>
    <p><strong>Status:</strong>
        <?php foreach (['PENDENTE', 'APROVADO', 'ENTREGUE'] as $st): ?>
            <?= Html::a(
                $st,
                ['set-status', 'id' => $model->id, 'status' => $st],
                [
                    'class' => $st == $model->status
                        ? 'px-2 py-0.5 bg-blue-600 text-white text-xs rounded'
                        : 'px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded',
                    'data-method' => 'post',
                    'data-confirm' => 'Alterar status?'
                ]
            ) ?>
        <?php endforeach; ?>
    </p>

    <h2 class="mt-4 font-semibold">Itens</h2>
    <table class="w-full text-sm border mt-2">
        <thead>
            <tr>
                <th>Exemplar</th>
                <th>Qtd</th>
                <th>Valor</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->itemCompras as $it): ?>
                <tr class="border-t">
                    <td class="px-2 py-1"><?= Html::encode(substr($it->exemplar_id, 0, 8)) ?></td>
                    <td class="px-2 py-1"><?= $it->quantidade ?></td>
                    <td class="px-2 py-1">R$ <?= number_format($it->valor_unitario, 2, ',', '.') ?></td>
                    <td class="px-2 py-1">R$
                        <?= number_format($it->quantidade * $it->valor_unitario, 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p class="text-right font-semibold mt-2">
        Total: R$ <?= number_format($model->valor_total, 2, ',', '.') ?>
    </p>

    <div class="mt-4 space-x-2">
        <?= Html::a(
            'Editar',
            ['update', 'id' => $model->id],
            ['class' => 'bg-primary text-white px-3 py-1 rounded']
        ) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'text-gray-600']) ?>
    </div>
</div>
