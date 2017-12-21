<?php

use yii\db\Migration;

/**
 * Class m171221_222047_modify_pin_column_from_clientes_table
 */
class m171221_222047_modify_pin_column_from_clientes_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('clientes', 'pin', 'varchar(5)');
    }

    public function down()
    {
        $this->alterColumn('clientes', 'pin', 'varchar(15)');
    }
}
