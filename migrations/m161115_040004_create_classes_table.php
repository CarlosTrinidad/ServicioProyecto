<?php

use yii\db\Migration;

/**
 * Handles the creation for table `classes`.
 */
class m161115_040004_create_classes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('classes', [
            'id' => $this->primaryKey(),
            'id_subject' => $this->integer(11)->notNull(),
            'id_room' => $this->integer(11)->notNull(),
            'day' => $this->boolean(1)->notNull(),
            'time_start' => $this->time()->notNull(),
            'time_end' => $this->time()->notNull()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

/*FK de subject para classes*/
        // creates index for column `id_subject`
        $this->createIndex(
            'idx-classes-id_subject',
            'classes',
            'id_subject'
        );

         // add foreign key for table `subject`
        $this->addForeignKey(
            'fk-classes-id_subject',
            'classes',
            'id_subject',
            'subject',
            'id',
            'CASCADE'
        );

/*FK de room para classes*/
        // creates index for column `id_room`
        $this->createIndex(
            'idx-classes-id_room',
            'classes',
            'id_room'
        );

         // add foreign key for table `room`
        $this->addForeignKey(
            'fk-classes-id_room',
            'classes',
            'id_room',
            'room',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
      // drops foreign key for table `subject`
      $this->dropForeignKey(
          'fk-classes-id_subject',
          'classesclasses'
      );

      // drops index for column `id_subject`
      $this->dropIndex(
          'idx-classes-id_subject',
          'classes'
      );

      // drops foreign key for table `room`
      $this->dropForeignKey(
          'fk-classes-id_room',
          'classes'
      );

      // drops index for column `id_room`
      $this->dropIndex(
          'idx-classes-id_room',
          'classes'
      );

      $this->dropTable('classes');
    }
}
