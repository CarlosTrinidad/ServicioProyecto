<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubjectSemester */

$this->title = $model->semester->name;
$this->params['breadcrumbs'][] = ['label' => 'Subject Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-semester-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->semester_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->semester_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             [
             'attribute' =>  'semester_id',
             'label' => 'Semester',
             'value' => $model->semester->name,
            ],
             [
             'attribute' => 'subject_id',
             'label' => 'Subjects',
             'value' => $model->nameSubjects,
            ],
        ],
    ]) ?>

</div>
