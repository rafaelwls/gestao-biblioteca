<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doacoes}}`.
 */
class m250624_231556_create_doacoes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        $this->createTable('doacoes', [
            'id'               => 'UUID PRIMARY KEY DEFAULT gen_random_uuid()',
            'usuario_id'       => 'UUID NOT NULL',
            'titulo'           => $this->string(255)->notNull(),
            'autor'            => $this->string(255)->null(),
            'estado'           => $this->string(50)->null(),
            'status'           => "VARCHAR(20) NOT NULL DEFAULT 'PENDENTE'",
            'data_solicitacao' => 'TIMESTAMP NOT NULL DEFAULT NOW()',
        ]);

        $this->addForeignKey(
            'fk_doacao_usuario',
            'doacoes',
            'usuario_id',
            'usuarios',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_doacao_usuario', 'doacoes');
        $this->dropTable('doacoes');
    }
}
