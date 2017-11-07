<?php

use yii\db\Migration;

/**
 * Handles dropping email from table `clientes`.
 */
class m171107_165707_drop_email_column_from_clientes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('clientes', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('clientes', 'email', $this->string(255));
    }
}
