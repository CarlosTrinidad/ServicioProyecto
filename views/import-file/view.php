<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\ImportFile */
/* @var $form ActiveForm */


$this->title = Yii::t('app', 'Import: Results');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="import-file-result">

  <h1><?= Html::encode($this->title) ?></h1>

  <h2>Instructores</h2>
  <?php if (Yii::$app->session->hasFlash('totalInstructors')): ?>
    <div class="alert alert-success alert-dismissable">

    <?php echo "Se agregaron ".Yii::$app->session->getFlash('totalInstructors')." instructores";?>
    </div>
  <?php endif; ?>

  <h2>Obligatorias</h2>

  <?php if (Yii::$app->session->hasFlash('totalObligatorias')): ?>
    <div class="alert alert-success alert-dismissable">
      <?php echo "Se agregaron ".Yii::$app->session->getFlash('totalObligatorias')." asignaturas obligatorias"?>
    </div>
  <?php endif; ?>

  <h2>Opt-Libres</h2>
  <?php if (Yii::$app->session->hasFlash('totalOPT-LIBRE')): ?>
    <div class="alert alert-success alert-dismissable">
      <?php echo "Se agregaron ".Yii::$app->session->getFlash('totalOPT-LIBRE')." optativas/libres";?>
    </div>
  <?php endif; ?>

  <h2>Posgrado</h2>
  <?php if (Yii::$app->session->hasFlash('totalPOSGRADO')): ?>
    <div class="alert alert-success alert-dismissable">
      <?php echo "Se agregaron ".Yii::$app->session->getFlash('totalPOSGRADO')." asignaturas de posgrado";    ?>
    </div>
  <?php endif; ?>

  <h2>Errores:</h2>

  <?php if (Yii::$app->session->hasFlash('errorProf')): ?>
    <div class="alert alert-danger alert-dismissable">
      <?php echo "Verifique los datos: ",'</br>';?>

    <?php
          foreach (Yii::$app->session->getFlash('errorProf') as $message) {
        echo ($message);
        echo '<br/>';
      }
    ?>
    </div>
  <?php endif; ?>


</div>
