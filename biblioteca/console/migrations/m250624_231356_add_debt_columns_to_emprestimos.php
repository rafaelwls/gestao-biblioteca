php yii migrate/create create_doacoes_table
<?php

use yii\db\Migration;

class m250624_231356_add_debt_columns_to_emprestimos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('emprestimos', 'multa_paga', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('emprestimos', 'data_pagamento', $this->timestamp()->null());
    }
    public function safeDown()
    {
        $this->dropColumn('emprestimos', 'data_pagamento');
        $this->dropColumn('emprestimos', 'multa_paga');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250624_231356_add_debt_columns_to_emprestimos cannot be reverted.\n";

        return false;
    }
    */
}
