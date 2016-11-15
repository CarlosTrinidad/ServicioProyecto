<?php

use yii\db\Migration;

/**
 * Handles the creation for table `program_subject`.
 */
class m161115_024550_create_program_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('program_subject', [
          'id_subject' => $this->integer(11)->notNull(),
          'id_program' => $this->integer(11)->notNull(),
      ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

/*FK de subject para program_subject*/
      // creates index for column `id_subject`
      $this->createIndex(
          'idx-program_subject-id_subject',
          'program_subject',
          'id_subject'
      );

       // add foreign key for table `subject`
      $this->addForeignKey(
          'fk-program_subject-id_subject',
          'program_subject',
          'id_subject',
          'subject',
          'id',
          'CASCADE'
      );

/*FK de study_program para instructor_subject*/
      // creates index for column `id_program`
      $this->createIndex(
          'idx-program_subject-id_program',
          'program_subject',
          'id_program'
      );

       // add foreign key for table `study_program`
      $this->addForeignKey(
          'fk-program_subject-id_program',
          'program_subject',
          'id_program',
          'study_program',
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
          'fk-program_subject-id_subject',
          'program_subject'
      );

      // drops index for column `id_subject`
      $this->dropIndex(
          'idx-program_subject-id_subject',
          'program_subject'
      );

      // drops foreign key for table `study_program`
      $this->dropForeignKey(
          'fk-program_subject-id_program',
          'program_subject'
      );

      // drops index for column `id_program`
      $this->dropIndex(
          'idx-program_subject-id_program',
          'program_subject'
      );

      $this->dropTable('program_subject');
    }
}
