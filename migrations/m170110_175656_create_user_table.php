<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170110_175656_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(200)->notNull(),
            'email' => $this->string(200)->notNull(),
            'password' => $this->string(255)->notNull()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
