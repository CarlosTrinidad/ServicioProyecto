<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use app\models\Subject;
use app\models\Room;
use app\models\Schedule;

/* @var $this yii\web\View */
/* @var $model app\models\Classes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_subject')->dropDownList(
        ArrayHelper::map(Subject::find()->orderBy('name')->all(), 'id', 'name'),
        ['prompt'=>'Select subject']
    ) ?>

    <?= $form->field($model, 'id_room')->dropDownList(
            ArrayHelper::map(Room::find()->orderBy('room')->all(), 'id', 'room'),
            ['prompt'=>'Select schoolroom']
            ) ?>

<!--     <?= $form->field($model, 'day')->dropDownList(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'],[1,2,3,4,5,6,0]) ?>
 -->

     <?= $form->field($model, 'day')->dropDownList(['1' => 'Lunes','2' => 'Martes', '3'=> 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado', '0' => 'Domingo']) ?>

    <?= $form->field($model, 'time_start')->dropDownList(
        ArrayHelper::map(Schedule::find()->all(),'id','schedule'),['prompt'=>'Hora de Inicio']
    ) ?>

    <?= $form->field($model, 'time_end')->dropDownList(
        ArrayHelper::map(Schedule::find()->all(),'id','schedule'),['prompt'=>'Hora de Finalización']
    ) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
