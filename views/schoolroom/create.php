<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Schoolroom */

$this->title = Yii::t('app', 'Create Schoolroom');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schoolrooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schoolroom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
