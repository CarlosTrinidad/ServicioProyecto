<?php

namespace app\controllers;

use Yii;
use app\models\Semester;
use app\models\SemesterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Subject;
use app\models\Instructor;

/**
 * SemesterController implements the CRUD actions for Semester model.
 */
class SemesterController extends Controller
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
     * Lists all Semester models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemesterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Semester model.
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
     * Creates a new Semester model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Semester();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionImportExcel(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        $inputFile = "files/import.xlsx";

        try{
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $sheetnames = $objReader->listWorksheetNames($inputFile);
        }
        catch(Exeption $e) {
            die('Error');
        }
        $sheetIndex = 0;
        $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);
        $objPHPExcel = $objReader->load($inputFile);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        print_r($sheetData[2]['B']);

        $sheetIndex = 4;
        $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);
        $objPHPExcel2 = $objReader->load($inputFile);
        $sheetData2 = $objPHPExcel2->getActiveSheet()->toArray(null,true,true,true);
        print_r($sheetData2[2]['B']);

        // First sheet
        // $sheet = $objPHPExcel->getSheet(0);
        // $highestRow = $sheet->getHighestRow();
        // $highestColumn = $sheet->getHighestColumn();
        // for ($row=2; $row <= 3 ; $row++) { 
        //     # code...
        //     $newSubject = new Subject();
        //     $newSubject->name = $sheetData[$row]['B'];
        //     $newSubject->sp = $sheetData[$row]['C'];
        //     $newSubject->model = $sheetData[$row]['H'];
        //     $newSubject->semester = $sheetData[$row]['D'];
        //     $newSubject->save();

        // }
        echo "First sheet...Done!";

        // Fifth sheet
        // $sheetIndex = 4;
        // $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);
        // $objPHPExcel = $objReader->load($inputFile);
        // $sheetData = $objPHPExcel->getSheet(4)->toArray(null,true,true,true);

        // for ($row=2; $row <= 10 ; $row++) { 
        //     $newInstructor = new Instructor();
        //     $newInstructor->name = $sheetData[$row]['C'];
        //     $newInstructor->last_name = $sheetData[$row]['D'];
        //     $newInstructor->save();
        //     echo "Done!";
        // }
    }
    /**
     * Updates an existing Semester model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Semester model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Semester model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Semester the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Semester::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
