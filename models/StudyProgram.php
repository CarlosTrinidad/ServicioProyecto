<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "study_program".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProgramSubject[] $programSubjects
 */
class StudyProgram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_program';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramSubjects()
    {
        return $this->hasMany(ProgramSubject::className(), ['id_program' => 'id']);
    }

     public function getSemesters()
    {
        return $this->hasMany(Semester::className(), ['study_program_id' => 'id']);
    }

}
