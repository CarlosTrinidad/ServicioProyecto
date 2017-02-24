<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudyProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Study Programs');
$this->params['breadcrumbs'][] = $this->title;
$parameter = Subject::decideGuest('');
?>
<div class="study-program-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Study Program'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn',
             'template' => $parameter,
             'buttons' => [
             'schedule' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['study-program/schedule', 'id' => $model->id],[ 'title' => Yii::t('app', 'Schedule'),'aria-label'=>Yii::t('app', 'Schedule'),'data-pjax' => "0",]);
            },],
            ],
        ],
    ]); ?>
</div>
