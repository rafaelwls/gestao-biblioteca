<?php

use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Dashboard Administrativo';
?>

<h2>Livros Disponíveis</h2>
<?php
$dataProviderAvailable = new ArrayDataProvider([
    'allModels'  => $available,
    'pagination' => [
        'pageSize' => 5,
    ],
]);
?>
<?= GridView::widget([
    'dataProvider' => $dataProviderAvailable,
    'columns'      => [
        ['attribute' => 'livro.titulo', 'label' => 'Título'],
        ['attribute' => 'id',           'label' => 'Código', 'format' => 'text'],
    ],
    'pager' => [
        'options'              => ['class' => 'pagination justify-center mt-4 flex'],
        'linkOptions'          => ['class' => 'px-3 py-1 border rounded mx-1'], 
        'prevPageLabel'        => '< Anterior',
        'nextPageLabel'        => 'Próximo >',
    ],
]) ?>

<h2>Favoritos Cadastrados</h2>
<?php
$dataProviderFavorites = new ArrayDataProvider([
    'allModels'  => $allFavorites,
    'pagination' => [
        'pageSize' => 5,
    ],
]);
?>
<?= GridView::widget([
    'dataProvider' => $dataProviderFavorites,
    'columns'      => [
        ['attribute' => 'usuario.email', 'label' => 'Usuário'],
        ['attribute' => 'livro.titulo',  'label' => 'Livro'],
    ],
    'pager' => [
        'options'              => ['class' => 'pagination justify-center mt-4 flex'],
        'linkOptions'          => ['class' => 'px-3 py-1 border rounded mx-1'], 
        'prevPageLabel'        => '< Anterior',
        'nextPageLabel'        => 'Próximo >',
    ],
]) ?>

<h2>Empréstimos</h2>
<?php
$dataProviderLoans = new ArrayDataProvider([
    'allModels'  => $allLoans,
    'pagination' => [
        'pageSize' => 5,
    ],
]);
?>
<?= GridView::widget([
    'dataProvider' => $dataProviderLoans,
    'columns'      => [
        ['attribute' => 'usuario.email',         'label' => 'Usuário'],
        ['attribute' => 'exemplar.livro.titulo', 'label' => 'Livro'],
        'data_emprestimo:date',
        'data_devolucao_prevista:date',
        'data_devolucao_real:date',
        'multa_calculada',
    ],
    'pager' => [
        'options'              => ['class' => 'pagination justify-center mt-4 flex'],
        'linkOptions'          => ['class' => 'px-3 py-1 border rounded mx-1'], 
        'prevPageLabel'        => '< Anterior',
        'nextPageLabel'        => 'Próximo >',
    ],
]) ?>
