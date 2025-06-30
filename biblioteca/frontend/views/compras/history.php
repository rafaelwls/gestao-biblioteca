<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histórico de Compras'; 
?>
<div class="compras-history">
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
            'quantidade',
            [
                'attribute'=>'valor_unitario',
                'format'=>['currency','BRL'],
            ],
            [
                'attribute'=>'valor_total',
                'format'=>['currency','BRL'],
            ],
            'status',
            'data_compra:date',
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>fn($url,$m)=>Html::a('Detalhes',['view','id'=>$m->id],[
                        'class'=>'form-button'
                    ]),
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
