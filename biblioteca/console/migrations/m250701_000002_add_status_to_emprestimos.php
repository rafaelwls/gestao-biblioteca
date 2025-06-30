<?php

use yii\db\Migration;

class m250701_000002_add_status_to_emprestimos extends Migration
{
    public function safeUp()
    {
        // 1) cria o tipo ENUM para status dos empréstimos
        $this->execute("
            CREATE TYPE status_emprestimo AS ENUM (
                'PENDENTE',
                'APROVADO',
                'REJEITADO'
            )
        ");

        // 2) adiciona a coluna status (já existente exemplar_id, usuario_id etc.)
        $this->addColumn(
            'emprestimos',
            'status',
            "status_emprestimo NOT NULL DEFAULT 'PENDENTE'"
        );
    }

    public function safeDown()
    {
        $this->dropColumn('emprestimos', 'status');
        $this->execute("DROP TYPE status_emprestimo");
    }
}
