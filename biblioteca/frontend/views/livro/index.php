<?php
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Todos os Livros';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="flex justify-between mb-3">
    <input type="search" placeholder="Buscar por título ou autor…"
        class="px-3 py-2 rounded-md border w-80 text-sm">
    <?= Html::a('+ Adicionar Livro', ['create'], ['class' => 'bg-primary text-white px-3 py-1 rounded']) ?>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg w-full"> 
    <div class="overflow-x-auto"> 
        <table class="grid-view min-w-full table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Título</th>
                <th class="px-4 py-2">Autor</th>
                <th class="px-4 py-2">Gênero</th>
                <th class="px-4 py-2">ISBN</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $livro): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2"><?= Html::encode($livro->titulo) ?></td>
                    <td class="px-4 py-2"><?= Html::encode($livro->autor) ?></td>
                    <td class="px-4 py-2">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">
                            <?= Html::encode($livro->genero) ?>
                        </span>
                    </td>
                    <td class="px-4 py-2"><?= Html::encode($livro->isbn) ?></td>
                    <td class="px-4 py-2"><?= Html::encode($livro->status) ?></td>
                    <td class="px-4 py-2 text-center">
                        <?= Html::a('Editar', ['update', 'id' => $livro->id], ['class' => 'text-primary text-xs']) ?>
                        <?= Html::a('Inativar', ['delete', 'id' => $livro->id], [
                            'class' => 'text-red-500 text-xs',
                            'data-confirm' => 'Inativar este livro?',
                            'data-method'  => 'post'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= LinkPager::widget([
        'pagination'   => $dataProvider->pagination,
        'options'      => ['class' => 'pagination justify-center mt-4 flex'],
        'linkOptions'  => ['class' => 'px-3 py-1 border rounded mx-1'],
        'prevPageLabel'=> '< Anterior',
        'nextPageLabel'=> 'Próximo >',
    ]) ?>
</div>
