<?php

use yii\db\Migration;

/**
 * Handles the creation of table `imagens_anuncio`.
 */
class m171110_153917_create_imagens_anuncio_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('imagens_anuncio', [
            'anuncio_id' => $this->primaryKey(),
            'path_relativo' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-imagens-anuncio-anuncios_id',
            'imagens_anuncio',
            'anuncio_id'
        );

        $this->addForeignKey(
            'fk-imagens-anuncio-anuncios_id',
            'imagens_anuncio',
            'anuncio_id',
            'anuncios',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-imagens-anuncio-anuncios_id',
            'imagens_anuncio'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-imagens-anuncio-anuncios_id',
            'imagens_anuncio'
        );

        $this->dropTable('imagens_anuncio');
    }
}
