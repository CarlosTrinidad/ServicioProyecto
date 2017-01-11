<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use yii\web\Controller;
use app\models\Schedule;
use app\models\Semester;
use yii\helpers\Url;

class SemesterscheduleController extends Controller
{

	public function actionSemester($id){
    echo $id;
		\Yii::$app->session->set('returnUrl', Url::to(['semesterschedule/semester', 'id'=>$id]));

    $interval = Schedule::find()->all();
    $semester = Semester::findOne($id);
        return $this->render("semesterSchedule",["interval"=>$interval,"semester"=>$semester]);
	}

	public function actionSemesters(){
		\Yii::$app->session->set('returnUrl', Url::to(['semesterschedule/semesters']));

		$interval = Schedule::find()->all();
		$semesters = Semester::find()->all();
		return $this->render("semesterScheduleGroup",["interval"=>$interval,"semesters"=>$semesters]);
	}
}
