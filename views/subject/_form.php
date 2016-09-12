<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp')->textInput(['maxlength' => true]) ?>

  	<?= $form->field($model, 'model')->dropDownList(['MEFI','MEyA','MEFI/MEyA'],[0,1,2]) ?>

  	<?= $form->field($model, 'semester')->dropDownList(['1','2','3','4','5','6','7','8','9'],[1,2,3,4,5,6,7,8,9]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
