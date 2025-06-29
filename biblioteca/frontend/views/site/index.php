<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $available common\models\Exemplares[] */
/* @var $favorites common\models\Favoritos[] */
/* @var $activeLoans common\models\Emprestimos[] */
/* @var $loanHistory common\models\Emprestimos[] */

$this->title = 'Catálogo';
?>

<h2>Livros Disponíveis</h2>
<ul>
    <?php foreach ($available as $e): ?>
        <li>
            <?= Html::encode($e->livro->titulo) ?>
            – Exemplar #<?= $e->id ?>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Meus Favoritos</h2>
<ul>
    <?php foreach ($favorites as $f): ?>
        <li><?= Html::encode($f->livro->titulo) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Empréstimos Ativos</h2>
<ul>
    <?php foreach ($activeLoans as $loan): ?>
        <li>
            <?= Html::encode($loan->exemplar->livro->titulo) ?>
            – Previsto: <?= Yii::$app->formatter->asDate($loan->data_devolucao_prevista) ?>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Histórico de Empréstimos</h2>
<ul>
    <?php foreach ($loanHistory as $loan): ?>
        <li>
            <?= Html::encode($loan->exemplar->livro->titulo) ?>
            – Devolvido em <?= Yii::$app->formatter->asDate($loan->data_devolucao_real) ?>
        </li>
    <?php endforeach; ?>
</ul>
