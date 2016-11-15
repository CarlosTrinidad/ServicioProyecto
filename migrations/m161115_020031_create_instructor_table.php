<?php

use yii\db\Migration;

/**
 * Handles the creation for table `instructor`.
 */
class m161115_020031_create_instructor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('instructor', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('instructor');
    }
}
