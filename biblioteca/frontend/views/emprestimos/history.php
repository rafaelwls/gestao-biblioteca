<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Histórico de Empréstimos'; 
?>
<div class="emprestimos-history">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'yii\grid\SerialColumn'],
            [
                'label' => 'Livro',
                'value' => fn($m) => $m->exemplar->livro->titulo,
            ],
            [
                'label' => 'Usuário',
                'value' => fn($m) => $m->usuario->nome . ' ' . $m->usuario->sobrenome,
            ],
            'data_emprestimo:date',
            'data_devolucao_prevista:date',
            'status',
             
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
