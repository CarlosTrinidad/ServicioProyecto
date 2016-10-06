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
    public $programs;

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
            [['programs'], 'each', 'rule'=>['integer']],
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
    public static function primaryKey()
    {
        return ['id_subject'];
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

    public function saveAll(){
        if( $this->validate() ){
            if( !empty($this->programs) && is_array($this->programs) ){
                ProgramSubject::deleteAll([
                    'id_subject' => $this->id_subject,
                ]);
                foreach($this->programs as $program){
                    $newProgramSubject = new ProgramSubject();
                    $newProgramSubject->id_subject = $this->id_subject;
                    $newProgramSubject->id_program = $program;
                    $newProgramSubject->save(false);
                }
            }
            return true;
        }
        return false;
    }

    public function getNamePrograms(){

        $programSearch = ProgramSubject::find()->where(['id_subject' => $this->id_subject])->asArray()->all();
        $strProgram = '';
        foreach ($programSearch as $value) {
            $programName = StudyProgram::find()->where(['id' => $value['id_program']])->one();
           $arrProgram[] = $programName->name;
        }
        $strProgram = implode(", ", $arrProgram);
        return $strProgram;
    }
}
