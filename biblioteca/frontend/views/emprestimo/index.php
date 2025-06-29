<?php

use yii\helpers\Html; ?>
<h1 class="text-xl font-semibold mb-4">Histórico de Empréstimos</h1>
<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Emprestado</th>
            <th>Previsto</th>
            <th>Real</th>
            <th>Multa</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dp->models as $e): ?>
            <tr class="border-t hover:bg-gray-50">
                <td class="px-2 py-1"><?= Html::encode($e->usuario->nome) ?></td>
                <td><?= Html::encode($e->exemplar->livro->titulo) ?></td>
                <td><?= Yii::$app->formatter->asDate($e->data_emprestimo) ?></td>
                <td><?= Yii::$app->formatter->asDate($e->data_devolucao_prevista) ?></td>
                <td><?= $e->data_devolucao_real ? Yii::$app->formatter->asDate($e->data_devolucao_real) : '-' ?></td>
                <td><?= $e->multa_calculada > 0 ? 'R$ ' . number_format($e->multa_calculada, 2, ',', '.') : '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
