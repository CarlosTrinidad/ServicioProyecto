<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ImportFile */
/* @var $form ActiveForm */


$this->title = Yii::t('app', 'Import');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="import-file-index">

  <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <!-- <?= $form->field($model, 'fileImport') ?> -->

        <?= $form->field($model, 'fileImport')->fileInput() ?>

    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- import-file-index -->
