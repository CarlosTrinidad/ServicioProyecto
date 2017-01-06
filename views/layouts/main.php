<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Schedules',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'InstructorSchedule', 'url' => ['/instructorschedule/index']],
            ['label' => 'InstructorSubject', 'url' => ['/instructor-subject/index']],
            ['label' => 'ProgramSubject', 'url' => ['/program-subject/index']],
            ['label' => 'RoomSchedule', 'url' => ['/roomschedule/index']],
            ['label' => 'StudyProgram', 'url' => ['/study-program/index']],
            ['label' => 'Create',
            'items' => [
                '<li class="dropdown-header">Manage Classes</li>',
                 ['label' => 'Classes', 'url' => ['/classes/index']],
                 '<li class="divider"></li>',

                 '<li class="dropdown-header">Manage Instructors</li>',
                 ['label' => 'Instructors', 'url' => ['/instructor/index']],
                 '<li class="divider"></li>',

                 '<li class="dropdown-header">Manage Rooms</li>',
                 ['label' => 'Rooms', 'url' => ['/room/index']],
                 '<li class="divider"></li>',

                 '<li class="dropdown-header">Manage Subjects</li>',
                 ['label' => 'Subject', 'url' => ['/subject/index']],
                 '<li class="divider"></li>',

                 '<li class="dropdown-header">Manage Semesters</li>',
                 ['label' => 'Semester', 'url' => ['/semester/index']],
                 '<li class="divider"></li>',

                 '<li class="dropdown-header">Import data</li>',
                 ['label' => 'Import', 'url' => ['/import-file/index']],

               ],
            ],
            /*['label' => 'Contact', 'url' => ['/site/contact']],*/
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->name . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
