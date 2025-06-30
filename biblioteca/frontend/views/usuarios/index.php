<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Todos os Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="flex justify-between mb-3">
        <input
            type="search"
            placeholder="Buscar por nome ou e-mail…"
            class="px-3 py-2 rounded-md border w-80 text-sm"
        >
        <?= Html::a(
            '+ Adicionar Usuário',
            ['create'],
            ['class' => 'bg-primary text-white px-3 py-1 rounded']
        ) ?>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
        <div class="overflow-x-auto">
            <table class="grid-view min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nome</th>
                        <th class="px-4 py-2">Sobrenome</th>
                        <th class="px-4 py-2">E-mail</th>
                        <th class="px-4 py-2">Data Cadastro</th>
                        <th class="px-4 py-2">Data Validade</th>
                        <th class="px-4 py-2 text-center">Admin?</th>
                        <th class="px-4 py-2 text-center">Trabalhador?</th>
                        <th class="px-4 py-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dataProvider->models as $user): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?= Html::encode($user->nome) ?></td>
                        <td class="px-4 py-2"><?= Html::encode($user->sobrenome) ?></td>
                        <td class="px-4 py-2"><?= Html::encode($user->email) ?></td>
                        <td class="px-4 py-2"><?= Yii::$app->formatter->asDate($user->data_cadastro) ?></td>
                        <td class="px-4 py-2">
                            <?= $user->data_validade
                                ? Yii::$app->formatter->asDate($user->data_validade)
                                : '-' ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?= $user->is_admin ? '✔️' : '—' ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?= $user->is_trabalhador ? '✔️' : '—' ?>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <?= Html::a('Ver', ['view', 'id' => $user->id], ['class' => 'text-primary text-xs']) ?>
                            <?= Html::a('Editar', ['update', 'id' => $user->id], ['class' => 'text-primary text-xs']) ?>
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
    </div>

</div>
