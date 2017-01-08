<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use yii\web\Controller;
use app\models\Schedule;
use app\models\Semester;

class SemesterscheduleController extends Controller
{
	
	public function actionSemester($id){
    echo $id;
    $interval = Schedule::find()->all();
    $semester = Semester::findOne($id);
        return $this->render("semesterSchedule",["interval"=>$interval,"semester"=>$semester]);
	}
}

