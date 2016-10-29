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
            'id_subject' => Yii::t('app', 'Id Subject'),
            'id_room' => Yii::t('app', 'Id Room'),
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
            $this->addError('time_start', '');
            $this->addError('time_end', 'Existe un choque que con la siguiente clase: '
                .$class_search->one()->idSubject->name.', '
                .$class_search->one()->idRoom->room.', '
                .$class_search->one()->time_start.'-'.$class_search->one()->time_end
                );
        }
    }    
    public function validateInstructor()
    {
        $subjects_instructor = InstructorSubject::find()
                ->where(['id_subject' => $this->id_subject])
                ->all();
        //     echo '<br/>';
        //     echo '<br/>';

        // print_r($subjects_instructor);
        // if ($class_search->exists()) {
        //     $this->addError('time_start', '');
        //     $this->addError('time_end', 'Existe un choque que con la siguiente clase: '
        //         .$class_search->one()->idSubject->name.', '
        //         .$class_search->one()->idRoom->room.', '
        //         .$class_search->one()->time_start.'-'.$class_search->one()->time_end
        //         );
        // }
    }
    
}
