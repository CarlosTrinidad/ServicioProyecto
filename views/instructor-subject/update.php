<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstructorSubject */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Instructor-Subject',
]) . $model->idSubject->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instructor Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_subject, 'url' => ['view', 'id' => $model->id_subject]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="instructor-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
