<?php

use yii\db\Migration;

class m250621_210455_initial_schema extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    // 1) Habilita a extensão para gerar UUIDs
    $this->execute('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

    // 2) Cria os tipos ENUM (ordenados alfabeticamente)
    $this->execute(
      <<<'SQL'
CREATE TYPE motivo_remocao AS ENUM (
  'DANIFICADO',
  'DESATUALIZADO',
  'OUTRO',
  'PERDIDO'
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TYPE tipo_fluxo AS ENUM (
  'ENTRADA',
  'SAIDA'
);
SQL
    );

    // 3) Cria todas as tabelas com UUIDs e defaults gerando gen_random_uuid()
    $this->execute(
      <<<'SQL'
CREATE TABLE usuarios (
  id             UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
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

    $this->execute(
      <<<'SQL'
CREATE TABLE livros (
  id              UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
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

    $this->execute(
      <<<'SQL'
CREATE TABLE exemplares (
  id               UUID            PRIMARY KEY DEFAULT gen_random_uuid(),
  livro_id         UUID            NOT NULL REFERENCES livros(id),
  data_aquisicao   DATE            NOT NULL DEFAULT CURRENT_DATE,
  status           VARCHAR(20)     NOT NULL,
  estado           VARCHAR(50)     NOT NULL,
  codigo_barras    VARCHAR(50)     UNIQUE,
  data_remocao     DATE,
  motivo_remocao   motivo_remocao
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE emprestimos (
  id                      UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  exemplar_id             UUID        NOT NULL REFERENCES exemplares(id),
  usuario_id              UUID        NOT NULL REFERENCES usuarios(id),
  data_emprestimo         DATE        NOT NULL DEFAULT CURRENT_DATE,
  data_devolucao_prevista DATE        NOT NULL,
  data_devolucao_real     DATE,
  multa_calculada         NUMERIC(8,2) NOT NULL DEFAULT 0.00
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE compras (
  id            UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id    UUID        NOT NULL REFERENCES usuarios(id),
  data_compra   DATE        NOT NULL DEFAULT CURRENT_DATE,
  valor_total   NUMERIC(12,2) NOT NULL
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE item_compras (
  compra_id      UUID        NOT NULL REFERENCES compras(id) ON DELETE CASCADE,
  exemplar_id    UUID        NOT NULL REFERENCES exemplares(id),
  valor_unitario NUMERIC(10,2) NOT NULL,
  quantidade     INT         NOT NULL DEFAULT 1,
  PRIMARY KEY(compra_id, exemplar_id)
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE vendas (
  id           UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id   UUID        NOT NULL REFERENCES usuarios(id),
  data_venda   DATE        NOT NULL DEFAULT CURRENT_DATE,
  valor_total  NUMERIC(12,2) NOT NULL
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE item_vendas (
  venda_id       UUID        NOT NULL REFERENCES vendas(id) ON DELETE CASCADE,
  exemplar_id    UUID        NOT NULL REFERENCES exemplares(id),
  valor_unitario NUMERIC(10,2) NOT NULL,
  quantidade     INT         NOT NULL DEFAULT 1,
  PRIMARY KEY(venda_id, exemplar_id)
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE favoritos (
  id            UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id    UUID        NOT NULL REFERENCES usuarios(id),
  livro_id      UUID        NOT NULL REFERENCES livros(id),
  data_favorito DATE        NOT NULL DEFAULT CURRENT_DATE,
  UNIQUE(usuario_id, livro_id)
);
SQL
    );

    $this->execute(
      <<<'SQL'
CREATE TABLE fluxo_pessoas (
  id          UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
  usuario_id  UUID         NOT NULL REFERENCES usuarios(id),
  tipo        tipo_fluxo   NOT NULL,
  timestamp   TIMESTAMP    NOT NULL DEFAULT NOW()
);
SQL
    );
  }

  public function safeDown()
  {
    // Remove em ordem inversa para manter integridade
    $this->execute('DROP TABLE IF EXISTS fluxo_pessoas;');
    $this->execute('DROP TABLE IF EXISTS favoritos;');
    $this->execute('DROP TABLE IF EXISTS item_vendas;');
    $this->execute('DROP TABLE IF EXISTS vendas;');
    $this->execute('DROP TABLE IF EXISTS item_compras;');
    $this->execute('DROP TABLE IF EXISTS compras;');
    $this->execute('DROP TABLE IF EXISTS emprestimos;');
    $this->execute('DROP TABLE IF EXISTS exemplares;');
    $this->execute('DROP TABLE IF EXISTS livros;');
    $this->execute('DROP TABLE IF EXISTS usuarios;');
    $this->execute('DROP TYPE IF EXISTS tipo_fluxo;');
    $this->execute('DROP TYPE IF EXISTS motivo_remocao;');
    // (Opcional) remover extensão
    $this->execute('DROP EXTENSION IF EXISTS "pgcrypto";');
  }


  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250621_210455_initial_schema cannot be reverted.\n";

        return false;
    }
    */
}
