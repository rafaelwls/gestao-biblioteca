<?php

use yii\db\Migration;

class m250629_000001_merge_migrations extends Migration
{
    public function safeUp()
    {
        // === Migração m130524_201442_init (tabela user) ===
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id'                     => $this->primaryKey(),
            'username'               => $this->string()->notNull()->unique(),
            'auth_key'               => $this->string(32)->notNull(),
            'password_hash'          => $this->string()->notNull(),
            'password_reset_token'   => $this->string()->unique(),
            'email'                  => $this->string()->notNull()->unique(),
            'status'                 => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'             => $this->integer()->notNull(),
            'updated_at'             => $this->integer()->notNull(),
        ], $tableOptions);

        // === Migração m190124_110200_add_verification_token_column_to_user_table ===
        $this->addColumn('{{%user}}', 'verification_token', $this->string()->defaultValue(null));

        // === Migração m250621_210455_initial_schema ===
        // 1) Habilita extensão para gerar UUIDs
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        // 2) Cria tipos ENUM
        $this->execute(<<<'SQL'
CREATE TYPE motivo_remocao AS ENUM (
  'DANIFICADO',
  'DESATUALIZADO',
  'OUTRO',
  'PERDIDO'
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TYPE tipo_fluxo AS ENUM (
  'ENTRADA',
  'SAIDA'
);
SQL
        );

        // 3) Cria tabelas do esquema inicial
        $this->execute(<<<'SQL'
CREATE TABLE usuarios (
  id             UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  nome           VARCHAR(100) NOT NULL,
  sobrenome      VARCHAR(100) NOT NULL,
  email          VARCHAR(150) UNIQUE NOT NULL,
  data_cadastro  DATE         NOT NULL DEFAULT CURRENT_DATE,
  data_validade  DATE,
  is_admin       BOOLEAN      NOT NULL DEFAULT FALSE,
  is_trabalhador BOOLEAN      NOT NULL DEFAULT FALSE
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE livros (
  id              UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  isbn            VARCHAR(20)  UNIQUE,
  titulo          VARCHAR(255) NOT NULL,
  subtitulo       VARCHAR(255),
  ano_publicacao  INT,
  idioma          VARCHAR(50),
  paginas         INT,
  data_criacao    TIMESTAMP    NOT NULL DEFAULT NOW()
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE exemplares (
  id               UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  livro_id         UUID         NOT NULL REFERENCES livros(id),
  data_aquisicao   DATE         NOT NULL DEFAULT CURRENT_DATE,
  status           VARCHAR(20)  NOT NULL,
  estado           VARCHAR(50)  NOT NULL,
  codigo_barras    VARCHAR(50)  UNIQUE,
  data_remocao     DATE,
  motivo_remocao   motivo_remocao
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE emprestimos (
  id                      UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  exemplar_id             UUID         NOT NULL REFERENCES exemplares(id),
  usuario_id              UUID         NOT NULL REFERENCES usuarios(id),
  data_emprestimo         DATE         NOT NULL DEFAULT CURRENT_DATE,
  data_devolucao_prevista DATE         NOT NULL,
  data_devolucao_real     DATE,
  multa_calculada         NUMERIC(8,2) NOT NULL DEFAULT 0.00
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE compras (
  id            UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id    UUID         NOT NULL REFERENCES usuarios(id),
  data_compra   DATE         NOT NULL DEFAULT CURRENT_DATE,
  valor_total   NUMERIC(12,2) NOT NULL
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE item_compras (
  compra_id      UUID         NOT NULL REFERENCES compras(id) ON DELETE CASCADE,
  exemplar_id    UUID         NOT NULL REFERENCES exemplares(id),
  valor_unitario NUMERIC(10,2) NOT NULL,
  quantidade     INT          NOT NULL DEFAULT 1,
  PRIMARY KEY (compra_id, exemplar_id)
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE vendas (
  id           UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id   UUID         NOT NULL REFERENCES usuarios(id),
  data_venda   DATE         NOT NULL DEFAULT CURRENT_DATE,
  valor_total  NUMERIC(12,2) NOT NULL
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE item_vendas (
  venda_id       UUID         NOT NULL REFERENCES vendas(id) ON DELETE CASCADE,
  exemplar_id    UUID         NOT NULL REFERENCES exemplares(id),
  valor_unitario NUMERIC(10,2) NOT NULL,
  quantidade     INT          NOT NULL DEFAULT 1,
  PRIMARY KEY (venda_id, exemplar_id)
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE favoritos (
  id            UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id    UUID         NOT NULL REFERENCES usuarios(id),
  livro_id      UUID         NOT NULL REFERENCES livros(id),
  data_favorito DATE         NOT NULL DEFAULT CURRENT_DATE,
  UNIQUE (usuario_id, livro_id)
);
SQL
        );
        $this->execute(<<<'SQL'
CREATE TABLE fluxo_pessoas (
  id          UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id  UUID        NOT NULL REFERENCES usuarios(id),
  tipo        tipo_fluxo  NOT NULL,
  timestamp   TIMESTAMP   NOT NULL DEFAULT NOW()
);
SQL
        );

        // === Migração m250624_231356_add_debt_columns_to_emprestimos ===
        $this->addColumn('emprestimos', 'multa_paga',     $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('emprestimos', 'data_pagamento', $this->timestamp()->null());

        // === Migração m250624_231543_create_pedido_emprestimo_table ===
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";'); // idempotente
        $this->createTable('pedido_emprestimo', [
            'id'               => 'UUID PRIMARY KEY DEFAULT gen_random_uuid()',
            'usuario_id'       => 'UUID NOT NULL',
            'exemplar_id'      => 'UUID NOT NULL',
            'data_solicitacao' => 'TIMESTAMP NOT NULL DEFAULT NOW()',
            'status'           => "VARCHAR(20) NOT NULL DEFAULT 'PENDENTE'",
        ]);
        $this->addForeignKey('fk_pedido_usuario',   'pedido_emprestimo', 'usuario_id',  'usuarios',   'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_pedido_exemplar',  'pedido_emprestimo', 'exemplar_id', 'exemplares', 'id', 'CASCADE', 'CASCADE');

        // === Migração m250624_231556_create_doacoes_table ===
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
        $this->addForeignKey('fk_doacao_usuario', 'doacoes', 'usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');

        // === Migração m250628_162357_add_password_and_authkey_to_usuarios ===
        $this->addColumn('usuarios', 'senha',     $this->string(255)->notNull()->defaultValue(''));
        $this->addColumn('usuarios', 'auth_key',  $this->string(32)->notNull()->defaultValue(''));

        // === Migração m250628_162756_add_timestamps_to_usuarios ===
        $this->addColumn('usuarios', 'created_at', $this->timestamp()->notNull()->defaultExpression('NOW()'));
        $this->addColumn('usuarios', 'updated_at', $this->timestamp()->notNull()->defaultExpression('NOW()'));

        // === Migração m250628_213842_add_fields_to_livros ===
        $this->addColumn('livros', 'autor',  $this->string(255));
        $this->addColumn('livros', 'genero', $this->string(100));
        $this->addColumn('livros', 'status', $this->string(20)->notNull()->defaultValue('Disponível'));
        $this->addColumn('livros', 'sinopse',$this->text()->null());

        // === Migração m250628_214647_add_status_to_compras_vendas ===
        $this->addColumn('compras', 'status', $this->string(20)->notNull()->defaultValue('PENDENTE'));
        $this->addColumn('vendas',  'status', $this->string(20)->notNull()->defaultValue('PENDENTE'));
    }

    public function safeDown()
    {
        // Reverte em ordem inversa

        // últimas alterações de status
        $this->dropColumn('vendas',  'status');
        $this->dropColumn('compras', 'status');

        // campos em livros
        $this->dropColumn('livros', 'sinopse');
        $this->dropColumn('livros', 'status');
        $this->dropColumn('livros', 'genero');
        $this->dropColumn('livros', 'autor');

        // timestamps e auth em usuarios
        $this->dropColumn('usuarios', 'updated_at');
        $this->dropColumn('usuarios', 'created_at');
        $this->dropColumn('usuarios', 'auth_key');
        $this->dropColumn('usuarios', 'senha');

        // tabela doações
        $this->dropForeignKey('fk_doacao_usuario', 'doacoes');
        $this->dropTable('doacoes');

        // tabela pedido_emprestimo
        $this->dropForeignKey('fk_pedido_exemplar', 'pedido_emprestimo');
        $this->dropForeignKey('fk_pedido_usuario',   'pedido_emprestimo');
        $this->dropTable('pedido_emprestimo');

        // colunas de dívida em empréstimos
        $this->dropColumn('emprestimos', 'data_pagamento');
        $this->dropColumn('emprestimos', 'multa_paga');

        // esquema inicial (tabelas com UUID)
        $this->dropTable('fluxo_pessoas');
        $this->dropTable('favoritos');
        $this->dropTable('item_vendas');
        $this->dropTable('vendas');
        $this->dropTable('item_compras');
        $this->dropTable('compras');
        $this->dropTable('emprestimos');
        $this->dropTable('exemplares');
        $this->dropTable('livros');
        $this->dropTable('usuarios');

        // tipos ENUM
        $this->execute('DROP TYPE IF EXISTS tipo_fluxo;');
        $this->execute('DROP TYPE IF EXISTS motivo_remocao;');

        // user original
        $this->dropColumn('{{%user}}', 'verification_token');
        $this->dropTable('{{%user}}');
    }
}
