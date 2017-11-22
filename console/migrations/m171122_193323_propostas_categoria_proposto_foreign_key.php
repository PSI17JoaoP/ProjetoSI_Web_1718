<?php

use yii\db\Migration;

/**
 * Class m171122_193323_propostas_categoria_proposto_foreign_key
 */
class m171122_193323_propostas_categoria_proposto_foreign_key extends Migration
{
    public function up()
    {
        $this->createIndex(
            'idx-propostas-cat_proposto',
            'propostas',
            'cat_proposto'
        );

        $this->addForeignKey(
            'propostas_ibfk_3',
            'propostas',
            'cat_proposto',
            'categorias',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'propostas_ibfk_3',
            'propostas'
        );

        $this->dropIndex(
            'idx-propostas-cat_proposto',
            'propostas'
        );
    }
}
