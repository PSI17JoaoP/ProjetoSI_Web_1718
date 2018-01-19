<?php

use yii\db\Migration;

/**
 * Class m180119_141228_campos_cliente_v2
 */
class m180119_141228_campos_cliente_v2 extends Migration
{
    /**
     * @inheritdoc
     */
   /* public function safeUp()
    {

    }*/

    /**
     * @inheritdoc
     */
    /*public function safeDown()
    {
        echo "m180119_141228_campos_cliente_v2 cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('clientes', 'n_reviews', 'int(5) NOT NULL DEFAULT 0');
        $this->alterColumn('clientes', 'total_score', 'int(5) NOT NULL DEFAULT 0');
    }

    public function down()
    {
  
    }
    
}
