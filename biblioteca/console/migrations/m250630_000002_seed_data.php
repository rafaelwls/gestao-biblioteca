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

        // 3) Compras & Itens de Compra
        $compraIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $cid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $compraIds[] = $cid;
            $uid         = ($i % 2 === 0) ? $userId : $funcId;
            $valorUnit   = 10.00 * $i;

            $this->insert('compras', [
                'id'          => $cid,
                'usuario_id'  => $uid,
                'data_compra' => new Expression('CURRENT_DATE'),
                'valor_total' => $valorUnit,
            ]);
            $this->insert('item_compras', [
                'compra_id'      => $cid,
                'exemplar_id'    => $exemplarIds[$i - 1],
                'valor_unitario' => $valorUnit,
                'quantidade'     => 1,
            ]);
        }

        // 4) Vendas & Itens de Venda
        $vendaIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $vid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $vendaIds[] = $vid;
            $uid        = ($i % 2 === 0) ? $userId : $funcId;
            $valorUnit  = 15.00 * $i;

            $this->insert('vendas', [
                'id'          => $vid,
                'usuario_id'  => $uid,
                'data_venda'  => new Expression('CURRENT_DATE'),
                'valor_total' => $valorUnit,
            ]);
            $this->insert('item_vendas', [
                'venda_id'       => $vid,
                'exemplar_id'    => $exemplarIds[$i - 1],
                'valor_unitario' => $valorUnit,
                'quantidade'     => 1,
            ]);
        }

        // 5) Pedidos de Empréstimo
        for ($i = 1; $i <= 10; $i++) {
            $pid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $uid = ($i % 2 === 0) ? $userId : $funcId;

            $this->insert('pedido_emprestimo', [
                'id'               => $pid,
                'usuario_id'       => $uid,
                'exemplar_id'      => $exemplarIds[$i - 1],
                'data_solicitacao' => $nowExpr,
                'status'           => 'PENDENTE',
            ]);
        }

        // 6) Doações
        for ($i = 1; $i <= 10; $i++) {
            $did = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $uid = ($i % 2 === 0) ? $funcId : $userId;

            $this->insert('doacoes', [
                'id'               => $did,
                'usuario_id'       => $uid,
                'titulo'           => "Livro $i",
                'autor'            => "Autor $i",
                'estado'           => 'bom',
                'status'           => 'PENDENTE',
                'data_solicitacao' => $nowExpr,
            ]);
        }

        // 7) Empréstimos
        for ($i = 1; $i <= 10; $i++) {
            $eid = $this->db->createCommand("SELECT gen_random_uuid()")->queryScalar();
            $uid = ($i % 2 === 0) ? $userId : $funcId;

            $this->insert('emprestimos', [
                'id'                      => $eid,
                'exemplar_id'             => $exemplarIds[$i - 1],
                'usuario_id'              => $uid,
                'data_emprestimo'         => new Expression('CURRENT_DATE'),
                'data_devolucao_prevista' => new Expression("CURRENT_DATE + INTERVAL '7 days'"),
                'multa_calculada'         => 0.00,
            ]);
        }
    }

    public function safeDown()
    {
        $this->delete('emprestimos');
        $this->delete('doacoes');
        $this->delete('pedido_emprestimo');
        $this->delete('item_vendas');
        $this->delete('vendas');
        $this->delete('item_compras');
        $this->delete('compras');
        $this->delete('exemplares');
        $this->delete('livros');
        $this->delete('usuarios', ['email' => [
            'admin@biblioteca.com',
            'funcionario@biblioteca.com',
            'usuario@biblioteca.com',
        ]]);
    }
}
