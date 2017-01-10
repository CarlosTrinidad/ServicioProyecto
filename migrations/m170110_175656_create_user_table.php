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
            'name' => $this->string(40)->notNull(),
            'email' => $this->string(40)->notNull(),
            'password' => $this->string(40)->notNull()
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
