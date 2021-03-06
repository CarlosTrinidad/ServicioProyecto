<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
$parameter = Subject::decideGuest('');
?>
<div class="subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Subject'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Show Subjects Schedule'), ['subjectschedule/subjects'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'sp',
            'model',
            'type',
            //  'modality',

             ['class' => 'yii\grid\ActionColumn',
             'template' =>$parameter,
             'buttons' => [
             'schedule' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['subjectschedule/subject', 'id' => $model->id],[ 'title' => Yii::t('app', 'Schedule'),'aria-label'=>Yii::t('app', 'Schedule'),'data-pjax' => "0",]);
             },],
             ],],

    ]); ?>
</div>
