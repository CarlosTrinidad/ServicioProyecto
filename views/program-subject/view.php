<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramSubject */

$this->title = $model->idSubject->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Program Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-subject-view">

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
            [
             'attribute' => 'id_subject',
             'label' => 'Subject',
             'value' => $model->idSubject->name
             ],
             // [
             // 'label' => 'Program',
             //        'type'=>'text',
             // 'value' => $model->programs
             // ],
            [
             'attribute' => 'id_program',
             'label' => 'Programs',
             'value' => $model->namePrograms,
            ],
            // 'id_program',
        ],
    ]) ?>

</div>
