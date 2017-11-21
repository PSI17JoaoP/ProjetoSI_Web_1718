<?php

use yii\db\Migration;

/**
 * Handles the creation of table `imagens_anuncio`.
 */
class m171110_153917_create_imagens_anuncio_imagens_proposta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('imagens_anuncio', array(
            'id' => 'pk',
            'anuncio_id' => 'int(10) NOT NULL',
            'path_relativo' => 'varchar(255) NOT NULL'
        ), 'ENGINE=InnoDB');

        $this->createTable('imagens_proposta', array(
            'id' => 'pk',
            'proposta_id' => 'int(10) NOT NULL',
            'path_relativo' => 'varchar(255) NOT NULL'
        ), 'ENGINE=InnoDB');

        $this->createIndex(
            'idx-imagens-anuncio-anuncios_id',
            'imagens_anuncio',
            'anuncio_id'
        );

        $this->createIndex(
            'idx-imagens-proposta-propostas_id',
            'imagens_proposta',
            'proposta_id'
        );

        $this->addForeignKey(
            'fk-imagens-anuncio-anuncios_id',
            'imagens_anuncio',
            'anuncio_id',
            'anuncios',
            'id'
        );

        $this->addForeignKey(
            'fk-imagens-proposta-propostas_id',
            'imagens_proposta',
            'proposta_id',
            'propostas',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-imagens-anuncio-anuncios_id',
            'imagens_anuncio'
        );

        $this->dropForeignKey(
            'fk-imagens-proposta-propostas_id',
            'imagens_proposta'
        );

        $this->dropIndex(
            'idx-imagens-anuncio-anuncios_id',
            'imagens_anuncio'
        );

        $this->dropIndex(
            'idx-imagens-proposta-propostas_id',
            'imagens_proposta'
        );

        $this->dropTable('imagens_anuncio');

        $this->dropTable('imagens_proposta');
    }
}
