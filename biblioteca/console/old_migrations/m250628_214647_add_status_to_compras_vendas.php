<?php

use yii\db\Migration;

class m250628_214647_add_status_to_compras_vendas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('compras', 'status', $this->string(20)->notNull()->defaultValue('PENDENTE'));
        $this->addColumn('vendas',  'status', $this->string(20)->notNull()->defaultValue('PENDENTE'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vendas',  'status');
        $this->dropColumn('compras', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250628_214647_add_status_to_compras_vendas cannot be reverted.\n";

        return false;
    }
    */
}
