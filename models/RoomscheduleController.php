<?php
namespace app\controllers;
use app\models\Room;
use app\models\Subject;
use app\models\Classes;
use app\models\InstructorSubject;
use yii\web\Controller;

class RoomscheduleController extends Controller
{
	public function actionIndex(){
		$model = new Room();
		$model=$model::find()->all();
		$materias = new  Subject();
		$materias= $materias::find()->all();
        $clases= new Classes();
        $clases= $clases::find()->all();
		$section = "Salones";
		return $this->render("index",["model"=>$model,'section'=>$section,"materias"=>$materias,"clases"=>$clases]);


	}
}