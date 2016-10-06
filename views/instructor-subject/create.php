<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InstructorSubject */

$this->title = Yii::t('app', 'Create Instructor Subject');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instructor Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instructor-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
