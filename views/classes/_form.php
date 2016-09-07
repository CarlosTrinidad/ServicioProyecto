<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use app\models\Subject;
use app\models\Room;

/* @var $this yii\web\View */
/* @var $model app\models\Classes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_subject')->dropDownList(
        ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
        ['prompt'=>'Select subject']
    ) ?>

    <?= $form->field($model, 'id_room')->dropDownList(
            ArrayHelper::map(Room::find()->all(), 'id', 'room'),
            ['prompt'=>'Select schoolroom']
            ) ?>

    <?= $form->field($model, 'day')->dropDownList(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'],[1,2,3,4,5,6,0]) ?>

    <?= $form->field($model, 'time_start')->widget(TimePicker::classname(), [
                'pluginOptions' => [
                    'showMeridian' => false,
                    'defaultTime' => 'current'
    ]]) ?>
    <?= $form->field($model, 'time_end')->widget(TimePicker::classname(), [
                'pluginOptions' => [
                    'showMeridian' => false,
                    'defaultTime' => 'current'
    ]]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
