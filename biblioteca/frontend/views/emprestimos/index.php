<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empréstimos Pendentes'; 
?>
<div class="emprestimos-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{approve} {reject}',
                'buttons' => [
                    'approve' => fn($url, $m) => Html::a('Aprovar', ['approve','id'=>$m->id], [
                        'class' => 'form-button form-button-primary',
                        'data-method' => 'post',
                    ]),
                    'reject'  => fn($url, $m) => Html::a('Rejeitar', ['reject','id'=>$m->id], [
                        'class' => 'form-button form-button-secondary',
                        'data-method' => 'post',
                    ]),
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
