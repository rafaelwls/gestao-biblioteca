<?php

use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $available common\models\Exemplares[] */
/* @var $allFavorites common\models\Favoritos[] */
/* @var $allLoans common\models\Emprestimos[] */

$this->title = '';
?>

<h2>Livros Disponíveis</h2>
<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $available,
    ]),
    'columns' => [
        ['attribute' => 'livro.titulo', 'label' => 'Título'],
        'id:integer',
    ]
]) ?>

<h2>Favoritos Cadastrados</h2>
<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $allFavorites,
    ]),
    'columns' => [
        ['attribute' => 'usuario.email', 'label' => 'Usuário'],
        ['attribute' => 'livro.titulo', 'label' => 'Livro'],
    ]
]) ?>

<h2>Empréstimos</h2>
<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $allLoans,
    ]),
    'columns' => [
        ['attribute' => 'usuario.email', 'label' => 'Usuário'],
        ['attribute' => 'exemplar.livro.titulo', 'label' => 'Livro'],
        'data_emprestimo:date',
        'data_devolucao_prevista:date',
        'data_devolucao_real:date',
        'multa_calculada',
    ]
]) ?>
