<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "program_subject".
 *
 * @property integer $id_subject
 * @property integer $id_program
 *
 * @property StudyProgram $idProgram
 * @property Subject $idSubject
 */
class ProgramSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'program_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'id_program'], 'required'],
            [['id_subject', 'id_program'], 'integer'],
            [['id_program'], 'exist', 'skipOnError' => true, 'targetClass' => StudyProgram::className(), 'targetAttribute' => ['id_program' => 'id']],
            [['id_subject'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['id_subject' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_subject' => Yii::t('app', 'Id Subject'),
            'id_program' => Yii::t('app', 'Id Program'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(StudyProgram::className(), ['id' => 'id_program']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'id_subject']);
    }
}
