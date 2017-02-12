<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SemesterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Semesters');
$this->params['breadcrumbs'][] = $this->title;
$parameter = Subject::decideGuest('');
?>
<div class="semester-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Semester'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Show Semesters Schedule'), ['semesterschedule/semesters'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a(Yii::t('app', 'Export data to Excel'), ['export-excel'], ['class' => 'btn btn-info']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
			[
				'value' => 'studyProgram.name',
				'header' => 'Study Program',
			],
             ['class' => 'yii\grid\ActionColumn',
             'template' =>$parameter,
             'buttons' => [
             'schedule' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['semesterschedule/semester', 'id' => $model->id],[ 'title' => Yii::t('app', 'Schedule'),'aria-label'=>Yii::t('app', 'Schedule'),'data-pjax' => "0",]);
            },],
            ],
        ],
    ]); ?>
</div>
