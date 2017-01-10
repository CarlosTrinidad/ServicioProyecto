<?php

namespace app\controllers;

use Yii;
use app\models\Classes;
use app\models\ClassesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClassesController implements the CRUD actions for Classes model.
 */
class ClassesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Classes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClassesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Classes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Classes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($day = null, $time_start = null, $subject = null, $return = null)
    {

        // get a session variable. The following usages are equivalent:
        $model = new Classes();
        $ref = Yii::$app->request->referrer;
        if(!empty($time_start)) $model->time_start = $time_start;
        if(!empty($day)) $model->day = $day;
        if(!empty($subject)) $model->id_subject = $subject;
        if(!empty($return)) $model->day = $day;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          if ($return == 'yes'){
              return $this->redirect(\Yii::$app->session->get('returnUrl'));
          }else{
            return $this->redirect(['view', 'id' => $model->id]);
          }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Classes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $return = null)
    {
        $model = $this->findModel($id);
        // $this->findModel($id)->delete();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

          if ($return == 'yes'){
              return $this->redirect(\Yii::$app->session->get('returnUrl'));
          }else{
            return $this->redirect(['view', 'id' => $model->id]);
          }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Classes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,  $return = null)
    {
        $this->findModel($id)->delete();

        if ($return == 'yes'){
            return $this->redirect(\Yii::$app->session->get('returnUrl'));
        }else{
          return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Classes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Classes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
