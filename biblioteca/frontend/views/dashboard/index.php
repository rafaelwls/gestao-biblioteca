<?php

use yii\helpers\Html;

$this->title = 'Dashboard';
?>

<h2>Livros Disponíveis</h2>
<div class="row">
    <?php foreach ($available as $livro): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= Html::encode($livro->titulo) ?></h5>
                    <p class="card-text text-muted"><?= Html::encode($livro->idioma) ?></p>
                    <?= Html::a('Detalhes', ['livro/view', 'id' => $livro->id], [
                        'class' => 'btn btn-primary mt-auto'
                    ]) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h2>Meus Favoritos</h2>
<ul class="list-group mb-4">
    <?php foreach ($favorites as $fav): ?>
        <li class="list-group-item">
            <?= Html::encode($fav->livro->titulo) ?>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Meus Empréstimos</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Livro</th>
            <th>Data</th>
            <th>Prevista</th>
            <th>Devolução</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($loans as $ln): ?>
            <tr>
                <td><?= Html::encode($ln->exemplar->livro->titulo) ?></td>
                <td><?= $ln->data_emprestimo ?></td>
                <td><?= $ln->data_devolucao_prevista ?></td>
                <td><?= $ln->data_devolucao_real ?: '<em>—</em>' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
