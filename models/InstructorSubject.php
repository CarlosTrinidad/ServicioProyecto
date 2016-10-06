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
    public $instructors;
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
            [['id_subject'], 'required'],
            [['id_subject'], 'integer'],
            [['instructors'], 'each', 'rule'=>['integer']],
            // [['instructors'], 'each', 'rule'=>['exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['id_instructor' => 'id']]],
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

    public static function primaryKey()
    {
        return ['id_subject'];
        // return ['id_subject','id_instructor'];
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

    public function saveAll(){
        if( $this->validate() ){
            if( !empty($this->instructors) && is_array($this->instructors) ){
                InstructorSubject::deleteAll([
                    'id_subject' => $this->id_subject,
                ]);
                foreach($this->instructors as $instructor){
                    $newInstructorSubject = new InstructorSubject();
                    $newInstructorSubject->id_subject = $this->id_subject;
                    $newInstructorSubject->id_instructor = $instructor;
                    $newInstructorSubject->save(false);
                }
            }
            return true;
        }
        return false;
    }

    public function getNameInstructors(){
        // aqui buscas los demàs registros del mismo subject y lo guardas en la variable instructors
        $instrSearch = InstructorSubject::find()->where(['id_subject' => $this->id_subject])->asArray()->all();
        $strInstructors = '';
        foreach ($instrSearch as $value) {
            $instrName = Instructor::find()->where(['id' => $value['id_instructor']])->one();
            $arrInstructors[] = $instrName->name.' '.$instrName->last_name;
        }
        $strInstructors = implode(", ", $arrInstructors);
        return $strInstructors;
    }
}
