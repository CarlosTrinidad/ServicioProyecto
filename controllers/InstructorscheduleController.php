<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use yii\web\Controller;

class InstructorscheduleController extends Controller
{
	public function actionIndex(){
		$model = new Instructor();
		$model=$model::find()->all();
		$materias = new  Subject();
		$materias= $materias::find()->all();
        $clases= new Classes();
        $clases= $clases::find()->all();
		$section = "profesores";
		return $this->render("index",["model"=>$model,'section'=>$section,"materias"=>$materias,"clases"=>$clases]);


	}
	
		public function actionInstructor($id){
	$instructor = Instructor::findOne($id);
	$interval = Schedule::find()->all();

      return $this->render("teacherSchedule",["instructor"=>$instructor,"interval"=>$interval]);
	}
}