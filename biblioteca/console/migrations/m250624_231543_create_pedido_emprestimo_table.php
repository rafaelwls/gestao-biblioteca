<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pedido_emprestimo}}`.
 */
class m250624_231543_create_pedido_emprestimo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        $this->createTable('pedido_emprestimo', [
            // define o id como UUID via SQL
            'id'               => 'UUID PRIMARY KEY DEFAULT gen_random_uuid()',
            'usuario_id'       => 'UUID NOT NULL',
            'exemplar_id'      => 'UUID NOT NULL',
            'data_solicitacao' => 'TIMESTAMP NOT NULL DEFAULT NOW()',
            'status'           => "VARCHAR(20) NOT NULL DEFAULT 'PENDENTE'",
        ]);

        $this->addForeignKey(
            'fk_pedido_usuario',
            'pedido_emprestimo',
            'usuario_id',
            'usuarios',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_pedido_exemplar',
            'pedido_emprestimo',
            'exemplar_id',
            'exemplares',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_pedido_exemplar', 'pedido_emprestimo');
        $this->dropForeignKey('fk_pedido_usuario',   'pedido_emprestimo');
        $this->dropTable('pedido_emprestimo');
    }
}
