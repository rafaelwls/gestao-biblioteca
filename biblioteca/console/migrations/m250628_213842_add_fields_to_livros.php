<?php

use yii\db\Migration;

class m250628_213842_add_fields_to_livros extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('livros', 'autor',   $this->string(255));
        $this->addColumn('livros', 'genero',  $this->string(100));
        $this->addColumn('livros', 'status',  $this->string(20)->notNull()->defaultValue('Disponível'));
        $this->addColumn('livros', 'sinopse', $this->text()->null());
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('livros', 'sinopse');
        $this->dropColumn('livros', 'status');
        $this->dropColumn('livros', 'genero');
        $this->dropColumn('livros', 'autor');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250628_213842_add_fields_to_livros cannot be reverted.\n";

        return false;
    }
    */
}
