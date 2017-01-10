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

	public function actionRoom($id){
    echo $id;
		\Yii::$app->session->set('returnUrl', Url::to(['roomschedule/room', 'id'=>$id]));

    $interval = Schedule::find()->all();
    $room = Room::findOne($id);
        return $this->render("roomSchedule",["interval"=>$interval,"room"=>$room]);
	}
}
