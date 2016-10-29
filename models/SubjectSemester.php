<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject_semester".
 *
 * @property integer $subject_id
 * @property integer $semester_id
 *
 * @property Semester $semester
 * @property Subject $subject
 */
class SubjectSemester extends \yii\db\ActiveRecord
{
      public $subjects;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject_semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_id'], 'required'],
            [['semester_id'], 'integer'],
            [['subjects'], 'each', 'rule'=>['integer']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subject_id' => 'Subject ID',
            'semester_id' => 'Semester',
        ];
    }

  public static function primaryKey()
    {
        return ['semester_id'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function saveAll(){
         if( $this->validate() ){
             if( !empty($this->subjects) && is_array($this->subjects) ){
                 SubjectSemester::deleteAll([
                     'semester_id' => $this->semester_id,
                 ]);
                 foreach($this->subjects as $subject){
                     $newSemesterSubject = new SubjectSemester();
                     $newSemesterSubject->semester_id = $this->semester_id;
                     $newSemesterSubject->subject_id = $subject;
                     $newSemesterSubject->save(false);
                 }
             }
             return true;
        }
         return false;
     }
 
     public function getNameSubjects(){
         // aqui buscas los demàs registros del mismo subject y lo guardas en la variable instructors
         $subSearch = SubjectSemester::find()->where(['semester_id' => $this->semester_id])->asArray()->all();
         $strSubjects = '';
         foreach ($subSearch as $value) {
             $subName = Subject::find()->where(['id' => $value['subject_id']])->one();
             $arrSubjects[] = $subName->name;
         }
         $strSubjects = implode(", ", $arrSubjects);
         return $strSubjects;
     }

    
}
