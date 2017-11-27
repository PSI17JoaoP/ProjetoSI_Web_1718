<?php

use yii\db\Migration;

/**
 * Class m171127_112955_modify_pin_column
 */
class m171127_112955_modify_pin_column extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('clientes', 'pin', 'varchar(15)');
    }

    public function down()
    {
        $this->alterColumn('clientes', 'pin', 'int(5)');
    }
}
