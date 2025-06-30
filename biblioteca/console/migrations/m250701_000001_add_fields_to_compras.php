<?php

use yii\db\Migration;

class m250701_000001_add_fields_to_compras extends Migration
{
    public function safeUp()
{
    // 1) cria o tipo ENUM para status
    $this->execute("
        CREATE TYPE status_compra AS ENUM (
            'PENDENTE',
            'APROVADA',
            'REJEITADA'
        )
    ");
 
   
}


    public function safeDown()
    {
        $this->dropColumn('compras', 'status');
        $this->dropColumn('compras', 'valor_unitario');
        $this->dropColumn('compras', 'quantidade');
        $this->dropForeignKey('fk_compras_exemplar', 'compras');
        $this->dropColumn('compras', 'exemplar_id');
        $this->execute("DROP TYPE status_compra");
    }
}
