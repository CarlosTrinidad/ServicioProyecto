<?php

use yii\db\Migration;

/**
 * Handles the creation for table `subject_semester`.
 */
class m161115_032814_create_subject_semester_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subject_semester', [        
            'subject_id' => 'int NOT NULL',
            'semester_id' => 'int NOT NULL',
            'PRIMARY KEY (`subject_id`, `semester_id`)'
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

        /*FK de subject para subject_semester*/
                // creates index for column `subject_id`
                $this->createIndex(
                    'idx-subject_semester-subject_id',
                    'subject_semester',
                    'subject_id'
                );

                 // add foreign key for table `subject`
                $this->addForeignKey(
                    'fk-subject_semester-subject_id',
                    'subject_semester',
                    'subject_id',
                    'subject',
                    'id',
                    'CASCADE'
                );

        /*FK de semester para subject_semester*/
                // creates index for column `semester_id`
                $this->createIndex(
                    'idx-subject_semester-semester_id',
                    'subject_semester',
                    'semester_id'
                );

                 // add foreign key for table `semester`
                $this->addForeignKey(
                    'fk-subject_semester-semester_id',
                    'subject_semester',
                    'semester_id',
                    'semester',
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
          'fk-subject_semester-subject_id',
          'subject_semester'
      );

      // drops index for column `subject_id`
      $this->dropIndex(
          'idx-subject_semester-subject_id',
          'subject_semester'
      );

      // drops foreign key for table `semester`
      $this->dropForeignKey(
          'fk-subject_semester-semester_id',
          'subject_semester'
      );

      // drops index for column `semester_id`
      $this->dropIndex(
          'idx-subject_semester-semester_id',
          'subject_semester'
      );

      $this->dropTable('subject_semester');
    }
}
