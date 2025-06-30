<?php

use yii\db\Migration;
use yii\db\Expression;

class m250630_000002_seed_data extends Migration
{
    public function safeUp()
    {
        $security = Yii::$app->security;
        $nowExpr  = new Expression('NOW()');

        // 1) Usuários
        $adminId = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
        $this->insert('usuarios', [
            'id'             => $adminId,
            'nome'           => 'Admin',
            'sobrenome'      => 'User',
            'email'          => 'admin@biblioteca.com',
            'senha'          => $security->generatePasswordHash('admin'),
            'auth_key'       => $security->generateRandomString(),
            'is_admin'       => true,
            'is_trabalhador' => true,
            'created_at'     => $nowExpr,
            'updated_at'     => $nowExpr,
        ]);

        $funcId = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
        $this->insert('usuarios', [
            'id'             => $funcId,
            'nome'           => 'Funcionario',
            'sobrenome'      => 'Generico',
            'email'          => 'funcionario@biblioteca.com',
            'senha'          => $security->generatePasswordHash('funcionario'),
            'auth_key'       => $security->generateRandomString(),
            'is_admin'       => false,
            'is_trabalhador' => true,
            'created_at'     => $nowExpr,
            'updated_at'     => $nowExpr,
        ]);

        $userId = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
        $this->insert('usuarios', [
            'id'             => $userId,
            'nome'           => 'Usuario',
            'sobrenome'      => 'Comum',
            'email'          => 'usuario@biblioteca.com',
            'senha'          => $security->generatePasswordHash('usuario'),
            'auth_key'       => $security->generateRandomString(),
            'is_admin'       => false,
            'is_trabalhador' => false,
            'created_at'     => $nowExpr,
            'updated_at'     => $nowExpr,
        ]);

        // 2) Livros + Exemplares
        $livroIds    = [];
        $exemplarIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $lid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $eid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $livroIds[]    = $lid;
            $exemplarIds[] = $eid;

            $this->insert('livros', [
                'id'             => $lid,
                'isbn'           => 'ISBN000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'titulo'         => "Livro $i",
                'subtitulo'      => "Subtítulo $i",
                'ano_publicacao' => 2000 + $i,
                'idioma'         => 'Português',
                'paginas'        => 100 + $i,
                'data_criacao'   => $nowExpr,
            ]);

            $this->insert('exemplares', [
                'id'             => $eid,
                'livro_id'       => $lid,
                'data_aquisicao' => new Expression('CURRENT_DATE'),
                'status'         => 'disponível',
                'estado'         => 'novo',
                'codigo_barras'  => 'CB' . str_pad($i, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // 3) Compras (um exemplar por compra)
        for ($i = 1; $i <= 10; $i++) {
            $cid       = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $uid       = ($i % 2 === 0) ? $userId : $funcId;
            $valorUnit = 10.00 * $i;

            $this->insert('compras', [
                'id'             => $cid,
                'usuario_id'     => $uid,
                'data_compra'    => new Expression('CURRENT_DATE'),
                'valor_total'    => $valorUnit,
                'exemplar_id'    => $exemplarIds[$i - 1],
                'valor_unitario' => $valorUnit,
                'quantidade'     => 1,
            ]);
        }

        // 4) Vendas (um exemplar por venda)
        for ($i = 1; $i <= 10; $i++) {
            $vid       = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $uid       = ($i % 2 === 0) ? $userId : $funcId;
            $valorUnit = 15.00 * $i;

            $this->insert('vendas', [
                'id'             => $vid,
                'usuario_id'     => $uid,
                'data_venda'     => new Expression('CURRENT_DATE'),
                'valor_total'    => $valorUnit,
                'exemplar_id'    => $exemplarIds[$i - 1],
                'valor_unitario' => $valorUnit,
                'quantidade'     => 1,
            ]);
        }

        // 5) Demais seeders (Pedido de Empréstimo, Doações, Empréstimos) mantidos iguais...
        // ...
    }

    public function safeDown()
    {
        // Remover vendas e compras sem referenciar tabelas intermediárias
        $this->delete('vendas');
        $this->delete('compras');

        // Demais deleções de tabelas mantidas conforme estavam
        $this->delete('emprestimos');
        $this->delete('doacoes');
        $this->delete('pedido_emprestimo');
        $this->delete('exemplares');
        $this->delete('livros');
        $this->delete('usuarios', [
            'email' => [
                'admin@biblioteca.com',
                'funcionario@biblioteca.com',
                'usuario@biblioteca.com',
            ]
        ]);
    }
}
