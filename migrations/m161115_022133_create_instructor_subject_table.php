<?php

use yii\db\Migration;

/**
 * Handles the creation for table `instructor_subject`.
 */
class m161115_022133_create_instructor_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('instructor_subject', [
            'id_subject' => $this->integer(11)->notNull(),
            'id_instructor' => $this->integer(11)->notNull(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

/*FK de subject para instructor_subject*/
        // creates index for column `id_subject`
        $this->createIndex(
            'idx-instructor_subject-id_subject',
            'instructor_subject',
            'id_subject'
        );

         // add foreign key for table `subject`
        $this->addForeignKey(
            'fk-instructor_subject-id_subject',
            'instructor_subject',
            'id_subject',
            'subject',
            'id',
            'CASCADE'
        );

/*FK de instructor para instructor_subject*/
        // creates index for column `id_instructor`
        $this->createIndex(
            'idx-instructor_subject-id_instructor',
            'instructor_subject',
            'id_instructor'
        );

         // add foreign key for table `instructor`
        $this->addForeignKey(
            'fk-instructor_subject-id_instructor',
            'instructor_subject',
            'id_instructor',
            'instructor',
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
            'fk-instructor_subject-id_subject',
            'instructor_subject'
        );

        // drops index for column `id_subject`
        $this->dropIndex(
            'idx-instructor_subject-id_subject',
            'instructor_subject'
        );

        // drops foreign key for table `instructor`
        $this->dropForeignKey(
            'fk-instructor_subject-id_instructor',
            'instructor_subject'
        );

        // drops index for column `id_instructor`
        $this->dropIndex(
            'idx-instructor_subject-id_instructor',
            'instructor_subject'
        );

        $this->dropTable('instructor_subject');
    }
}
