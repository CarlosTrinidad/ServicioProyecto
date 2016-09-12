<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $name
 * @property string $sp
 * @property integer $model
 * @property integer $semester
 *
 * @property Classes[] $classes
 * @property InstructorSubject[] $instructorSubjects
 * @property ProgramSubject[] $programSubjects
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sp', 'model', 'semester'], 'required'],
            [['model', 'semester'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['sp'], 'string', 'max' => 20],
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
            'sp' => Yii::t('app', 'Sp'),
            'model' => Yii::t('app', 'Model'),
            'semester' => Yii::t('app', 'Semester'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(Classes::className(), ['id_subject' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructorSubjects()
    {
        return $this->hasMany(InstructorSubject::className(), ['id_subject' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramSubjects()
    {
        return $this->hasMany(ProgramSubject::className(), ['id_subject' => 'id']);
    }
}
