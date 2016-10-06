<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProgramSubject */

$this->title = Yii::t('app', 'Create Program Subject');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Program Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
