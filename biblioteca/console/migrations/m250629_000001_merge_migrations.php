<?php

use yii\db\Migration;

class m250629_000001_merge_migrations extends Migration
{
    public function safeUp()
    {
        // === Extensões e ENUMs ===
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');
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

        // === Tabela user (original Yii2) ===
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
            'verification_token'     => $this->string()->defaultValue(null),
        ], $tableOptions);

        // === Esquema da biblioteca ===

        // 1) Usuários
        $this->execute(<<<'SQL'
CREATE TABLE usuarios (
  id             UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  nome           VARCHAR(100) NOT NULL,
  sobrenome      VARCHAR(100) NOT NULL,
  email          VARCHAR(150) UNIQUE NOT NULL,
  data_cadastro  DATE         NOT NULL DEFAULT CURRENT_DATE,
  data_validade  DATE,
  is_admin       BOOLEAN      NOT NULL DEFAULT FALSE,
  is_trabalhador BOOLEAN      NOT NULL DEFAULT FALSE,
  senha          VARCHAR(255) NOT NULL DEFAULT '',
  auth_key       VARCHAR(32)  NOT NULL DEFAULT '',
  created_at     TIMESTAMP    NOT NULL DEFAULT NOW(),
  updated_at     TIMESTAMP    NOT NULL DEFAULT NOW()
);
SQL
        );

        // 2) Livros
        $this->execute(<<<'SQL'
CREATE TABLE livros (
  id              UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  isbn            VARCHAR(20)  UNIQUE,
  titulo          VARCHAR(255) NOT NULL,
  subtitulo       VARCHAR(255),
  ano_publicacao  INT,
  idioma          VARCHAR(50),
  paginas         INT,
  data_criacao    TIMESTAMP    NOT NULL DEFAULT NOW(),
  autor           VARCHAR(255),
  genero          VARCHAR(100),
  status          VARCHAR(20)  NOT NULL DEFAULT 'Disponível',
  sinopse         TEXT
);
SQL
        );

        // 3) Exemplares
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

        // 4) Empréstimos
        $this->execute(<<<'SQL'
CREATE TABLE emprestimos (
  id                      UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  exemplar_id             UUID         NOT NULL REFERENCES exemplares(id),
  usuario_id              UUID         NOT NULL REFERENCES usuarios(id),
  data_emprestimo         DATE         NOT NULL DEFAULT CURRENT_DATE,
  data_devolucao_prevista DATE         NOT NULL,
  data_devolucao_real     DATE,
  multa_calculada         NUMERIC(8,2) NOT NULL DEFAULT 0.00,
  multa_paga              BOOLEAN      NOT NULL DEFAULT FALSE,
  data_pagamento          TIMESTAMP
);
SQL
        );

        // 5) Compras
        $this->execute(<<<'SQL'
CREATE TABLE compras (
  id               UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id       UUID         NOT NULL REFERENCES usuarios(id),
  data_compra      DATE         NOT NULL DEFAULT CURRENT_DATE,
  valor_total      NUMERIC(12,2) NOT NULL,
  exemplar_id      UUID         NOT NULL REFERENCES exemplares(id),
  valor_unitario   NUMERIC(10,2) NOT NULL,
  quantidade       INT          NOT NULL DEFAULT 1,
  status           VARCHAR(20)  NOT NULL DEFAULT 'PENDENTE'
);
SQL
        );

        // 6) Vendas
        $this->execute(<<<'SQL'
CREATE TABLE vendas (
  id               UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id       UUID         NOT NULL REFERENCES usuarios(id),
  data_venda       DATE         NOT NULL DEFAULT CURRENT_DATE,
  valor_total      NUMERIC(12,2) NOT NULL,
  exemplar_id      UUID         NOT NULL REFERENCES exemplares(id),
  valor_unitario   NUMERIC(10,2) NOT NULL,
  quantidade       INT          NOT NULL DEFAULT 1,
  status           VARCHAR(20)  NOT NULL DEFAULT 'PENDENTE'
);
SQL
        );

        // 7) Favoritos
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

        // 8) Fluxo de pessoas
        $this->execute(<<<'SQL'
CREATE TABLE fluxo_pessoas (
  id          UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id  UUID        NOT NULL REFERENCES usuarios(id),
  tipo        tipo_fluxo  NOT NULL,
  timestamp   TIMESTAMP   NOT NULL DEFAULT NOW()
);
SQL
        );

        // 9) Pedido de Empréstimo
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');
        $this->execute(<<<'SQL'
CREATE TABLE pedido_emprestimo (
  id               UUID      PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id       UUID      NOT NULL REFERENCES usuarios(id),
  exemplar_id      UUID      NOT NULL REFERENCES exemplares(id),
  data_solicitacao TIMESTAMP NOT NULL DEFAULT NOW(),
  status           VARCHAR(20) NOT NULL DEFAULT 'PENDENTE'
);
SQL
        );

        // 10) Doações
        $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');
        $this->execute(<<<'SQL'
CREATE TABLE doacoes (
  id               UUID      PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id       UUID      NOT NULL REFERENCES usuarios(id),
  titulo           VARCHAR(255) NOT NULL,
  autor            VARCHAR(255),
  estado           VARCHAR(50),
  status           VARCHAR(20) NOT NULL DEFAULT 'PENDENTE',
  data_solicitacao TIMESTAMP NOT NULL DEFAULT NOW()
);
SQL
        );
    }

    public function safeDown()
    {
        // Reverte em ordem inversa
        $this->execute('DROP TABLE IF EXISTS doacoes;');
        $this->execute('DROP TABLE IF EXISTS pedido_emprestimo;');
        $this->execute('DROP TABLE IF EXISTS fluxo_pessoas;');
        $this->execute('DROP TABLE IF EXISTS favoritos;');
        $this->execute('DROP TABLE IF EXISTS vendas;');
        $this->execute('DROP TABLE IF EXISTS compras;');
        $this->execute('DROP TABLE IF EXISTS emprestimos;');
        $this->execute('DROP TABLE IF EXISTS exemplares;');
        $this->execute('DROP TABLE IF EXISTS livros;');
        $this->execute('DROP TABLE IF EXISTS usuarios;');

        // Tabela user original
        $this->dropColumn('{{%user}}', 'verification_token');
        $this->dropTable('{{%user}}');

        // ENUMs e extensão
        $this->execute('DROP TYPE IF EXISTS tipo_fluxo;');
        $this->execute('DROP TYPE IF EXISTS motivo_remocao;');
        $this->execute('DROP EXTENSION IF EXISTS "pgcrypto";');
    }
}
