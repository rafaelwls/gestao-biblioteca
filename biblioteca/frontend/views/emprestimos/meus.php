<?php

use yii\helpers\Html; ?>
<h1 class="text-xl font-semibold mb-4">Meus Empréstimos</h1>

<h2 class="font-semibold mb-2">Ativos</h2>
<table class="w-full text-sm mb-6">
    <thead>
        <tr>
            <th>Livro</th>
            <th>Devolver até</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ativos as $e): ?>
            <tr class="border-t">
                <td class="px-2 py-1"><?= Html::encode($e->exemplar->livro->titulo) ?></td>
                <td><?= Yii::$app->formatter->asDate($e->data_devolucao_prevista) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2 class="font-semibold mb-2">Histórico</h2>
<table class="w-full text-sm">
    <thead>
        <tr>
            <th>Livro</th>
            <th>Emprestado em</th>
            <th>Devolvido em</th>
            <th>Multa</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hist as $e): ?>
            <tr class="border-t">
                <td class="px-2 py-1"><?= Html::encode($e->exemplar->livro->titulo) ?></td>
                <td><?= Yii::$app->formatter->asDate($e->data_emprestimo) ?></td>
                <td><?= Yii::$app->formatter->asDate($e->data_devolucao_real) ?></td>
                <td><?= $e->multa_calculada > 0 ? 'R$ ' . number_format($e->multa_calculada, 2, ',', '.') : '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
