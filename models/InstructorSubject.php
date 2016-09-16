<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instructor_subject".
 *
 * @property integer $id_subject
 * @property integer $id_instructor
 *
 * @property Instructor $idInstructor
 * @property Subject $idSubject
 */
class InstructorSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'id_instructor'], 'required'],
            [['id_subject', 'id_instructor'], 'integer'],
            [['id_instructor'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['id_instructor' => 'id']],
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
            'id_instructor' => Yii::t('app', 'Id Instructor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInstructor()
    {
        return $this->hasOne(Instructor::className(), ['id' => 'id_instructor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'id_subject']);
    }
}
