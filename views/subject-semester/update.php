<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubjectSemester */

$this->title = 'Update Subject Semester: ' . $model->semester_id;
$this->params['breadcrumbs'][] = ['label' => 'Subject Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->semester_id, 'url' => ['view', 'id' => $model->semester_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subject-semester-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
