<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Subject;
use app\models\Instructor;

/* @var $this yii\web\View */
/* @var $model app\models\InstructorSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instructor-subject-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_subject')->dropDownList(
            ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
            ['prompt'=>'Select subject']
         ) ?>

         <?= $form->field($model, 'instructors')->checkBoxList(
            // ArrayHelper::map(Instructor::find()->all(), 'id','last_name'),
            // Instructor::find()->select(['last_name', 'id'])->indexBy('id')->column(),
            Instructor::find()->select(["CONCAT(name, ' ', last_name) AS label,CONCAT(name, ' ', last_name) AS value, 'id as id'"])->indexBy('id')->column(),
            ['prompt'=>'Select instructor']
         ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end();?>

</div>
