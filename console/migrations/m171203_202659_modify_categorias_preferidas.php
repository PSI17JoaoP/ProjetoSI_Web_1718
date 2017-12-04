<?php

use yii\db\Migration;

/**
 * Class m171203_202659_modify_categorias_preferidas
 */
class m171203_202659_modify_categorias_preferidas extends Migration
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
        echo "m171203_202659_modify_categorias_preferidas cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropForeignKey(
            'categoria_preferida_ibfk_2',
            'categoria_preferida'
        );

        $this->renameColumn('categoria_preferida', 'id_categoria', 'categoria');
        $this->alterColumn('categoria_preferida', 'categoria', 'varchar(15)');
    }

    public function down()
    {
        
    }
    
}
