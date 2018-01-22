<?php

use yii\db\Migration;

/**
 * Class m180122_150854_tabela_notificacoes
 */
class m180122_150854_tabela_notificacoes extends Migration
{
    /**
     * @inheritdoc
     */
    /*
    public function safeUp()
    {

    }7*/

    /**
     * @inheritdoc
     */
    /*
    public function safeDown()
    {
        echo "m180122_150854_tabela_notificacoes cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('notificacoes', array(
            'id' => 'pk',
            'id_user' => 'int(11) NOT NULL',
            'mensagem' => 'varchar(255) NOT NULL',
            'lida' => 'int(1) NOT NULL DEFAULT 0'
        ), 'ENGINE=InnoDB');

        $this->createIndex(
            'idx-notificacoes_id_user',
            'notificacoes',
            'id_user'
        );

        $this->addForeignKey(
            'fk-notificacoes_id_user',
            'notificacoes',
            'id_user',
            'user',
            'id'
        );
    }

    public function down()
    {
    }
    
}
