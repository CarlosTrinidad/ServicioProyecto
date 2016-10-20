<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semester".
 *
 * @property integer $id
 * @property string $name
 * @property integer $study_program_id
 *
 * @property StudyProgram $studyProgram
 * @property SubjectSemester[] $subjectSemesters
 * @property Subject[] $subjects
 */
class Semester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'study_program_id'], 'required'],
            [['study_program_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['study_program_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudyProgram::className(), 'targetAttribute' => ['study_program_id' => 'id']],
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
            'study_program_id' => Yii::t('app', 'Study Program ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyProgram()
    {
        return $this->hasOne(StudyProgram::className(), ['id' => 'study_program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectSemesters()
    {
        return $this->hasMany(SubjectSemester::className(), ['semester_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subject::className(), ['id' => 'subject_id'])->viaTable('subject_semester', ['semester_id' => 'id']);
    }
}
