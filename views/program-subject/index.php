<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Classes;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProgramSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Program Subjects');
$this->params['breadcrumbs'][] = $this->title;
$parameter = Classes::decideGuest('');
?>
<div class="program-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Program Subject'), ['create'], ['class' => 'btn btn-success']) ?>
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
                          [
             'attribute' => 'id_program',
             'label' => 'Program',
             'value' => 'idProgram.name',
             // 'value' => $model->namePrograms,
             'value' => function ($model) {
                return $model->getNamePrograms();

                },
             ],
            // 'id_subject',
            // 'idSubject.name',
            // 'id_program',
            // 'idProgram.name',

            ['class' => 'yii\grid\ActionColumn','template' => $parameter],
        ],
    ]); ?>
</div>
