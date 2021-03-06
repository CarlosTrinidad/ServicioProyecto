<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use app\models\Schedule;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;

class InstructorscheduleController extends Controller
{
	// public function actionIndex(){
	// 	$model = new Instructor();
	// 	$model=$model::find()->all();
	// 	$materias = new  Subject();
	// 	$materias= $materias::find()->all();
  //       $clases= new Classes();
  //       $clases= $clases::find()->all();
	// 	$section = "profesores";
	// 	return $this->render("index",["model"=>$model,'section'=>$section,"materias"=>$materias,"clases"=>$clases]);
	// }

	public function behaviors()
	{
			return [
				'access' => [
											'class' => \yii\filters\AccessControl::className(),
											'only' => ['create','update','delete'],
											'rules' => [
													// allow authenticated users
													[
															'allow' => true,
															'roles' => ['@'],
													],
													// everything else is denied
											],
									],
					'verbs' => [
							'class' => VerbFilter::className(),
							'actions' => [
									'delete' => ['POST'],
							],
					],
			];
	}

	public function actionIndex(){
		\Yii::$app->session->set('returnUrl', Url::to(['instructorschedule/index']));

		$instructors = Instructor::find()->all();
		$section = "profesores";
		$interval = Schedule::find()->all();
		return $this->render("groupInstructorSchedule",["instructors"=>$instructors,'section'=>$section,"interval"=>$interval]);


	}

		public function actionInstructor($id){
			\Yii::$app->session->set('returnUrl', Url::to(['instructorschedule/instructor', 'id'=>$id]));
	$instructor = Instructor::findOne($id);
	$interval = Schedule::find()->all();
    return $this->render("teacherSchedule",["instructor"=>$instructor,"interval"=>$interval]);
	}
}
