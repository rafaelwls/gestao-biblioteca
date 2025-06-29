<?php if (!Yii::$app->user->identity->is_admin && !Yii::$app->user->identity->is_trabalhador): ?>
    <?= Html::a(
        'Solicitar Empréstimo',
        ['/emprestimos/solicitar', 'exemplar' => $model->id],
        ['class' => 'bg-primary text-white px-3 py-1 rounded', 'data-method' => 'post']
    ) ?>
<?php endif; ?>
