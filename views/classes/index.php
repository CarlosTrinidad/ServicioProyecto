<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ClassesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Classes');
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="classes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Classes'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
             'attribute' => 'id_subject',
             'value' => 'idSubject.name'
             ],
            [
             'attribute' => 'id_room',
             'value' => 'idRoom.room'
             ],
            [
             'attribute' => 'day',
             'value' => function ($model) {
                    $dias = array(  '1' => 'Lunes',
                    '2' => 'Martes',
                    '3'=> 'Miércoles',
                    '4' => 'Jueves',
                    '5' => 'Viernes',
                    '6' => 'Sábado',
                    '0' => 'Domingo');
                    $temp = ($model->day);
                    $valor = ArrayHelper::getValue($dias, $temp);
                    return $valor;
                },
             ],
            //'id',
            // 'id_subject',
            // 'id_room',
            //  'day',

            'time_start',
            'time_end',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

    ?>
</div>
