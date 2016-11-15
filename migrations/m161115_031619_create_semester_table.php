<?php

use yii\db\Migration;

/**
 * Handles the creation for table `semester`.
 */
class m161115_031619_create_semester_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('semester', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'study_program_id' => $this->integer(11)->notNull()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

/*FK de study_program para semester*/
        // creates index for column `study_program_id`
        $this->createIndex(
            'idx-semester-study_program_id',
            'semester',
            'study_program_id'
        );

         // add foreign key for table `study_program`
        $this->addForeignKey(
            'fk-semester-study_program_id',
            'semester',
            'study_program_id',
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
      // drops foreign key for table `study_program`
      $this->dropForeignKey(
          'fk-semester-study_program_id',
          'semester'
      );

      // drops index for column `study_program_id`
      $this->dropIndex(
          'idx-semester-study_program_id',
          'semester'
      );

      $this->dropTable('semester');
    }
}
