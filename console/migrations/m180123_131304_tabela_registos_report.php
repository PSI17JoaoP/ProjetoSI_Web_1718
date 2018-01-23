<?php

use yii\db\Migration;

/**
 * Class m180123_131304_tabela_registos_report
 */
class m180123_131304_tabela_registos_report extends Migration
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
        echo "m180123_131304_tabela_registos_report cannot be reverted.\n";

        return false;
    }*/

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $this->createTable('reports', array(
            'id' => 'pk',
            'id_user' => 'int(11) NOT NULL',
            'id_anuncio' => 'int(10) NOT NULL'
        ), 'ENGINE=InnoDB');

        $this->createIndex(
            'idx-reports_id_user',
            'reports',
            'id_user'
        );

        $this->createIndex(
            'idx-reports_id_anuncio',
            'reports',
            'id_anuncio'
        );

        $this->addForeignKey(
            'fk-reports_id_user',
            'reports',
            'id_user',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-reports_id_anuncio',
            'reports',
            'id_anuncio',
            'anuncios',
            'id'
        );
    }

    public function down()
    {
    }
    
}
