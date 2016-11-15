<?php

use yii\db\Migration;

/**
 * Handles the creation for table `room`.
 */
class m161115_015558_create_room_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('room', [
            'id' => $this->primaryKey(),
            'room' => $this->string(20)->notNull(),
            'capacity' => $this->boolean(1)->notNull(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('room');
    }
}
