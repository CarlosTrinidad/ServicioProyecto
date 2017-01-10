<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstructorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Instructors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instructor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Instructor'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Show Instructors Schedule'), ['instructorschedule/index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'last_name',


            ['class' => 'yii\grid\ActionColumn',
             'template' =>'{view} {update} {delete} {schedule}',
             'buttons' => [
             'schedule' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['instructorschedule/instructor', 'id' => $model->id],[ 'title' => Yii::t('app', 'Schedule'),'aria-label'=>Yii::t('app', 'Schedule'),'data-pjax' => "0",]);
            },],
            ],
        ],
    ]); ?>
</div>
