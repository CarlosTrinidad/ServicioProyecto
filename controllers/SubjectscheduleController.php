<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use yii\web\Controller;
use app\models\Schedule;
use app\models\Semester;
use yii\helpers\Url;

class SubjectscheduleController extends Controller
{

	public function actionSubject($id){
    echo $id;
		\Yii::$app->session->set('returnUrl', Url::to(['subjectschedule/subject', 'id'=>$id]));

    $interval = Schedule::find()->all();
    $subj = Subject::findOne($id);
        return $this->render("subjectSchedule",["interval"=>$interval,"subject"=>$subj]);
	}

	public function actionSubjects(){
		$interval = Schedule::find()->all();
        $subjects = Subject::find()->all();
        return $this->render("subjectGroupSchedule",["interval"=>$interval,"subjects"=>$subjects]);
	}
}
