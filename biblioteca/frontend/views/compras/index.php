<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Compras';
?>
<div class="compras-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=>[
            ['class'=>'yii\grid\SerialColumn'],
            [
                'label'=>'Livro',
                'value'=>fn($m)=>$m->exemplar->livro->titulo,
            ],
            'quantidade',
            [
                'attribute' => 'valor_unitario',
                'format'    => ['currency','BRL'],
            ],
            [
                'attribute' => 'valor_total',
                'format'    => ['currency','BRL'],
            ],

            'status',
            'data_compra:date',
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>Yii::$app->user->identity->is_trabalhador
                    ? '{approve} {reject} {view}' 
                    : '{view}',
                'buttons'=>[
                    'approve'=>fn($url,$m)=>Html::a('Aprovar',['approve','id'=>$m->id],[
                        'class'=>'form-button form-button-primary','data-method'=>'post'
                    ]),
                    'reject'=>fn($url,$m)=>Html::a('Rejeitar',['reject','id'=>$m->id],[
                        'class'=>'form-button form-button-secondary','data-method'=>'post'
                    ]),
                    'view'=>fn($url,$m)=>Html::a('Detalhes',['view','id'=>$m->id],[
                        'class'=>'form-button'
                    ]),
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
