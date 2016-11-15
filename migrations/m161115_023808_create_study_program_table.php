<?php

use yii\db\Migration;

/**
 * Handles the creation for table `study_program`.
 */
class m161115_023808_create_study_program_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('study_program', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('study_program');
    }
}
