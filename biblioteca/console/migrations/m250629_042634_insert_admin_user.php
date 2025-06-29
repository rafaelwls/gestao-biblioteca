<?php

use yii\db\Migration;

class m250629_042634_insert_admin_user extends Migration
{ 
    public function up()
    {
        $security    = Yii::$app->security;
        $passwordHash = $security->generatePasswordHash('admin');
        $authKey      = $security->generateRandomString();

        $this->insert('usuarios', [
            'id'             => new \yii\db\Expression('gen_random_uuid()'),
            'nome'           => 'Administrador',
            'sobrenome'      => 'Master',
            'email'          => 'admin@gmail.com',
            'data_cadastro'  => date('Y-m-d'),
            'is_admin'       => true,
            'is_trabalhador' => false,
            'senha'          => $passwordHash,     
            'auth_key'       => $authKey, 
        ]);
    }  
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250629_041712_insert_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250629_041712_insert_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
