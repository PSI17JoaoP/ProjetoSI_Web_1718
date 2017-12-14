<?php

use yii\db\Migration;

/**
 * Class m171214_114902_campo_imagem_conta
 */
class m171214_114902_campo_imagem_conta extends Migration
{
    /**
     * @inheritdoc
     */
    /*
    public function safeUp()
    {

    }*/

    /**
     * @inheritdoc
     */
    /*
    public function safeDown()
    {
        echo "m171214_114902_campo_imagem_conta cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('clientes', 'path_imagem', 'varchar(255)');
    }

    public function down()
    {

    }
    
}
