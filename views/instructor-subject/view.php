<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InstructorSubject */

$this->title = $model->idSubject->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instructor Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instructor-subject-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_subject], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_subject], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'idSubject.name',
            // 'idInstructor.name',
            // 'idInstructor.last_name',

            [
             'attribute' => 'id_instructor',
             'label' => 'Instructors',
             'value' => $model->nameInstructors,

             // 'value' => function ($model) {
             //    return $model->idInstructor->name. ' ' . $model->idInstructor->last_name;
             //    },
            ],
        ],
    ]) ?>

</div>
