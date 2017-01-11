<?php
namespace app\controllers;
use app\models\Instructor;
use app\models\Subject;
use app\models\Classes;
use yii\web\Controller;
use app\models\Schedule;
use app\models\Semester;
use app\models\Room;
use yii\helpers\Url;

class RoomscheduleController extends Controller
{
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
	public function actionRoom($id){
    echo $id;
		\Yii::$app->session->set('returnUrl', Url::to(['roomschedule/room', 'id'=>$id]));

    $interval = Schedule::find()->all();
    $room = Room::findOne($id);
        return $this->render("roomSchedule",["interval"=>$interval,"room"=>$room]);
	}


	public function actionRooms(){
		\Yii::$app->session->set('returnUrl', Url::to(['roomschedule/rooms']));

    $interval = Schedule::find()->all();
    $rooms = Room::find()->all();
        return $this->render("roomGroupSchedule",["interval"=>$interval,"rooms"=>$rooms]);
	}
}
