<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstructorSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Instructor Subjects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instructor-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Instructor Subject'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
             'attribute' => 'id_subject',
             'label' => 'Subject',
             'value' => 'idSubject.name'
             ],
            //  [
            //  'attribute' => 'Instructor name',
            //  'value' => 'idInstructor.name',
            //  ],
            // [
            //  'attribute' => 'Last name',
            //  'value' => 'idInstructor.last_name',
            //  ],
            [
             'attribute' => 'id_instructor',
             'label' => 'Instructor',
             'value' => function ($model) {
                return $model->getNameInstructors();
                // return $model->idInstructor->name. ' ' . $model->idInstructor->last_name;
                },

             ],

            // 'id_subject',
            // 'id_instructor',

            ['class' => 'yii\grid\ActionColumn',
             // 'template' => '{update}'
             ],
        ],
    ]); ?>
</div>
