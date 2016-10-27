<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubjectSemesterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subject Semesters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-semester-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Subject Semester', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
             'attribute' => 'semester_id',
             'label' => 'Semester',
             'value' => 'semester.name'
             ],
             
              [
             'attribute' => 'subject_id',
             'label' => 'Subject',
             'value' => function ($model) {
                return $model->nameSubjects;
                },
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
