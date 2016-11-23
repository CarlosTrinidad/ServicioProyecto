<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property integer $id
 * @property integer $id_subject
 * @property integer $id_room
 * @property integer $day
 * @property string $time_start
 * @property string $time_end
 *
 * @property Room $idRoom
 * @property Subject $idSubject
 */
class Classes extends \yii\db\ActiveRecord
{

    public $weekDays = array('1' => 'Lunes','2' => 'Martes', '3'=> 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado', '0' => 'Domingo');
    public $listErrors;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_start','time_end'], 'validateTime'],
            ['id_subject','validateInstructor'],
            [['id_subject', 'id_room', 'day', 'time_start', 'time_end'], 'required'],
            [['id_subject', 'id_room', 'day'], 'integer'],
            [['time_start', 'time_end'], 'safe'],
            [['id_room'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['id_room' => 'id']],
            [['id_subject'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['id_subject' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_subject' => Yii::t('app', 'Subject'),
            'id_room' => Yii::t('app', 'Room'),
            'day' => Yii::t('app', 'Day'),
            'time_start' => Yii::t('app', 'Time Start'),
            'time_end' => Yii::t('app', 'Time End'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'id_room']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'id_subject']);
    }

    public function validateTime()
    {
        $class_search = Classes::find()
                    ->andFilterWhere(['day'=> $this->day])
                    ->andFilterWhere(['id_room' => $this->id_room])
                    ->andFilterWhere(['<', 'time_start', $this->time_end])
                    ->andFilterWhere(['>', 'time_end', $this->time_start]);

        if ($class_search->exists()) {
            foreach ($class_search->all() as $class_single) {
                $this->addError('listErrors', 'Error con el horario: '
                    .$class_single->idSubject->name.', '
                    .$class_single->idRoom->room.', '
                    .$this->weekDays[$class_single->day].', '
                    .$class_single->time_start.'-'.$class_single->time_end
                    );
            }
        }
    }    
    public function validateInstructor()
    {
        // Materia -> Maestros -> Materias -> Clases -> choque con horario.
        $instructors_subject = InstructorSubject::find()
                ->where(['id_subject' => $this->id_subject])
                ->all();

        // Obtener todas las materias del maestro
        foreach ($instructors_subject as $profesor) {
            $materias = InstructorSubject::find()
                ->where(['id_instructor' => $profesor->id_instructor])
                ->all();
        // Buscar clase de cada materia
            foreach ($materias as $class_subject) {
                $class_search = Classes::find()
                    ->andFilterWhere(['id_subject'=> $class_subject->id_subject])
                    ->andFilterWhere(['<', 'time_start', $this->time_end])
                    ->andFilterWhere(['>', 'time_end', $this->time_start])
                    ->andFilterWhere(['day'=> $this->day]);


                if ($class_search->exists()) {
                    //Agregar cada uno de los errores
                    foreach ($class_search->all() as $class_single) {
                        $this->addError('listErrors', 'Error con profesor: '
                            .$class_single->idSubject->name.', '
                            .$profesor->idInstructor->name.' '.$profesor->idInstructor->last_name.', '
                            .$class_single->idRoom->room.', '
                            .$this->weekDays[$class_single->day].', '
                            .$class_single->time_start.'-'.$class_single->time_end
                            );
                    }

                }
            }

        }

    }
    
}
