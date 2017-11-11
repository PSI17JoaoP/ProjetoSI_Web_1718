<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `admin`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m171103_121647_drop_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('admin');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('admin', [
            'id_user' => $this->primaryKey(),
        ]);

        // creates index for column `id_user`
        $this->createIndex(
            'idx-admin-id_user',
            'admin',
            'id_user'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-admin-id_user',
            'admin',
            'id_user',
            'user',
            'id',
            'CASCADE'
        );
    }
}
