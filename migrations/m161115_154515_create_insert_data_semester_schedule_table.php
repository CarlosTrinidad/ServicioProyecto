<?php

use yii\db\Migration;

/**
 * Handles the creation for table `insert_data_semester_schedule`.
 */
class m161115_154515_create_insert_data_semester_schedule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
      $this->execute("INSERT INTO `study_program` (`id`, `name`) VALUES
        /*Ejemplo:
        (1, 'A'),
        (2, 'IC'),
        (3, 'CC');
        */
        /*Torres pega tu codigo aqui de los datos de la tabla study_program*/


      ");

      $this->execute("INSERT INTO `semester` (`id`, `name`, `study_program_id`) VALUES
        /*Ejemplo:
        (1, 'A1 MEFI', 1),
        (2, 'A2 MEFI', 1),
        (3, 'A3 MEFI', 1);
        */
        /*Torres pega tu codigo aqui de los datos de la tabla semester*/


      ");

      $this->execute("INSERT INTO `schedule` (`id`, `schedule`) VALUES
          /*Ejemplo:
          ('1', '07:00:00'),
          ('2', '07:30:00'),
          ('3', '08:00:00');
          */
            /*Torres pega tu codigo aqui de los datos de la tabla schedule*/


      ");

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
