<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProgramSubject */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Program Subject',
]) . $model->id_subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Program Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_subject, 'url' => ['view', 'id' => $model->id_subject]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="program-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
