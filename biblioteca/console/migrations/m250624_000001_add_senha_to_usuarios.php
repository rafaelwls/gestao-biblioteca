<?php

use yii\db\Migration;

/**
 * Class m250624_000001_add_senha_to_usuarios
 *
 * Adiciona o campo `senha` na tabela `usuarios`.
 */
class m250624_000001_add_senha_to_usuarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Adiciona coluna 'senha' após 'sobrenome' (VARCHAR(255) NOT NULL)
        $this->addColumn(
            '{{%usuarios}}',
            'senha',
            $this->string(255)->notNull()->after('sobrenome')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove a coluna 'senha'
        $this->dropColumn('{{%usuarios}}', 'senha');
    }
}
