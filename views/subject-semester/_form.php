<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Semester;
use app\models\Subject;
/* @var $this yii\web\View */
/* @var $model app\models\SubjectSemester */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-semester-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'semester_id')->dropDownList(
             ArrayHelper::map(Semester::find()->all(), 'id', 'name'),
             ['prompt'=>'Select semester']
          ) ?>

 <?= $form->field($model, 'subjects')->checkBoxList(
             ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
             ['prompt'=>'Select subject']
          ) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
