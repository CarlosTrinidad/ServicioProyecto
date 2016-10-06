<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Subject;
use app\models\StudyProgram;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_subject')->dropDownList(
        ArrayHelper::map(Subject::find()->all(), 'id', 'name'),
        	['prompt'=>'Select subject']
    ) ?>
    
    <?= $form->field($model, 'programs')->checkBoxList(
   		// ArrayHelper::map(StudyProgram::find()->all(), 'id','name'),
   		StudyProgram::find()->select(['name', 'id'])->indexBy('id')->column(),
        ['prompt'=>'Select Program']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
