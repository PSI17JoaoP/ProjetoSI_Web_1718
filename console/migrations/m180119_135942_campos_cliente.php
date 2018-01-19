<?php

use yii\db\Migration;

/**
 * Class m180119_135942_campos_cliente
 */
class m180119_135942_campos_cliente extends Migration
{
    /**
     * @inheritdoc
     */
    /*public function safeUp()
    {

    }*/

    /**
     * @inheritdoc
     */
    /*public function safeDown()
    {
        echo "m180119_135942_campos_cliente cannot be reverted.\n";

        return false;
    }*/

    
    //Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('clientes', 'n_reviews', 'int(5)');
        $this->addColumn('clientes', 'total_score', 'int(5)');
    }

    public function down()
    {
    }
    
}
