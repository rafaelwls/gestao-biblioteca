<?php

use yii\db\Migration;

class m250628_162357_add_password_and_authkey_to_usuarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'senha', $this->string(255)->notNull()->defaultValue(''));
        $this->addColumn('usuarios', 'auth_key', $this->string(32)->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250628_162357_add_password_and_authkey_to_usuarios cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250628_162357_add_password_and_authkey_to_usuarios cannot be reverted.\n";

        return false;
    }
    */
}
