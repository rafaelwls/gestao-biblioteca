<?php

use yii\db\Migration;

class m250628_162756_add_timestamps_to_usuarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'created_at', $this->timestamp()->notNull()->defaultExpression('NOW()'));
        $this->addColumn('usuarios', 'updated_at', $this->timestamp()->notNull()->defaultExpression('NOW()'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250628_162756_add_timestamps_to_usuarios cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250628_162756_add_timestamps_to_usuarios cannot be reverted.\n";

        return false;
    }
    */
}
