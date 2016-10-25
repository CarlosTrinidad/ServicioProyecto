<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\StudyProgram;

/* @var $this yii\web\View */
/* @var $model app\models\Semester */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semester-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'study_program_id')->dropDownList(
		ArrayHelper::map(StudyProgram::find()->all(), 'id', 'name'),
		['prompt'=>'Select Study Program']
	) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
