<?php

use yii\db\Migration;

/**
 * Handles the creation for table `subject`.
 */
class m161115_020936_create_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subject', [
            'id' => $this->primaryKey(),
            'name' => $this->string(110)->notNull(),
            'sp' => $this->string(100)->notNull(),
            'model' => $this->boolean(1),
            'type' => $this->string(15)->notNull(),
            'number'=> $this->string(15),
            'hour_pre'=> $this->string(15),
            'nr_np'=> $this->string(15),
            'semes'=> $this->string(15),
            'max_capacity'=>$this->string(15)

        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subject');
    }
}
