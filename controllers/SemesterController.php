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
use app\models\InstructorSubject;
use app\models\ProgramSubject;
use app\models\StudyProgram;

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

        $inputFile = "./files/import.xlsx";
        $profeError = array();

        try{
            // $sheetIndex = 0;
            // Fifth sheet (PROFESORES)
            $i=4;
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $sheetnames = $objReader->listWorksheetNames($inputFile);
            $objReader->setLoadSheetsOnly($sheetnames[$i]);
            print_r($sheetnames[$i]);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFile);
			// var_dump($objPHPExcel);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            // var_dump($sheetData);
            $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();
            // print_r($highestRow);

            for ($row=2; $row <= $highestRow ; $row++) { 
                // $newInstructor = new Instructor();
                // $newInstructor->name = $sheetData[$row]['C'];
                // $newInstructor->last_name = $sheetData[$row]['D'];
                // $newInstructor->save();

                $newInstructor = new Instructor();
                $newInstructor = Instructor::find()
                    ->andFilterWhere(['like' ,'name', $sheetData[$row]['C']])
                    ->andFilterWhere(['like' ,'last_name', $sheetData[$row]['D']])
                    ->one();
                if ($newInstructor == false) {
                    // echo "no existe";
                    $newInstructor = new Instructor();
                    $newInstructor->name = $sheetData[$row]['C'];
                    $newInstructor->last_name = $sheetData[$row]['D'];
                    $newInstructor->save();
                }
            }
            echo "...Instructors Done!";
            echo '<br/>';
            //covertir MEFI en 0
            $modelos = array('0' => 'MEFI','1' => 'MEyA', '2'=> 'MEFI-MEyA');
            $programasEduc = StudyProgram::find()
                    ->asArray()
                    ->all();
            // print_r($customers[0]['name']);




            for ($i=0; $i < 3 ; $i++) { 
                print_r($sheetnames[$i]);
                echo '<br/>';

                $objReader->setLoadSheetsOnly($sheetnames[$i]);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFile);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();

                for ($row=2; $row <= $highestRow ; $row++) { 


                    // echo '<br/>';
                    // print_r("No. ". $row.": ");
                    // print_r($sheetData[$row]['C']);
                    // print_r("   Sin numeros:");
                    // print_r($highestRow);
                    // echo '<br/>';


                $newSubject = new Subject();
                $newSubject = Subject::find()
                    ->andFilterWhere(['name' => $sheetData[$row]['B']])
                    ->andFilterWhere(['sp' => $sheetData[$row]['C']])
                    ->andFilterWhere(['model' => array_search($sheetData[$row]['H'],$modelos) ])
                    ->andFilterWhere(['semester' => (int)str_replace("°", "", $sheetData[$row]['D']) ])
                    ->andFilterWhere(['modality' => $sheetData[$row]['G']])
                    // ->filterWhere(['type' => $sheetData[$row]['B']])
                    ->one();

                    if ($newSubject == false) {
                        $newSubject = new Subject();
                        $newSubject->name = (string)$sheetData[$row]['B'];
                        $newSubject->sp = (string)$sheetData[$row]['C'];

                        if (array_search($sheetData[$row]['H'],$modelos) == false) {
                            $newSubject->model = 0;
                        }else{
                            $newSubject->model = array_search($sheetData[$row]['H'],$modelos);
                        }

                        $newSubject->semester = (int)str_replace("°", "", $sheetData[$row]['D']);

                        if ($sheetData[$row]['G'] == null) {
                            $newSubject->modality = "-";
                        }else{
                            $newSubject->modality = (string)$sheetData[$row]['G'];
                        }
                        $newSubject->type = (string)$sheetnames[$i];
                        $newSubject->save();
                    }else{
                        continue;
                    }

                //Limpiar formato de PE
                    $words = $sheetData[$row]['C'];
                    $words = preg_replace('/[0-9]+/', '', $words);
                    $words = str_replace(array( '(', ')' ), '', $words);
                // Buscar si en la columna PE existe en la BD
                    foreach($programasEduc as $result) {
                        if (strpos($words, $result['name']) === FALSE) {
                            continue;
                        }else{
                            // echo '<br/>';
                            // echo "Se encontro ".$result['name']." con id ".$result['id'];
                            $prgm_sub = new ProgramSubject();
                            $prgm_sub->id_program = $result['id'];
                            $prgm_sub->id_subject = $newSubject->id;
                            $prgm_sub->save();
                        }
                    }
                    

                    // Identificar si las materia es impartida por dos profesores
                    $pos = strpos($sheetData[$row]['N'], '/');
                    $pos2 = strpos($sheetData[$row]['O'], '/');
                    $nombres = array();
                    $apellidos = array();

                    if ($pos !== false) {
                        // echo "La cadena fue encontrada en la cadena";
                        // echo " y existe en la posición $pos";
                        $nombres[] = substr($sheetData[$row]['N'],0,$pos);
                        $nombres[] = substr($sheetData[$row]['N'],$pos+1);
                        $apellidos[] = substr($sheetData[$row]['O'],0,$pos2);
                        $apellidos[] = substr($sheetData[$row]['O'],$pos2+1);
                    } else {
                        $nombres[] = $sheetData[$row]['N'];
                        $apellidos[] = $sheetData[$row]['O'];
                    }

                    // Search Instructor en BD y obtener su id
                    for ($j=0; $j < count($nombres); $j++) { 
                        $instr = new Instructor();
                        $instr = Instructor::find()
                            // ->andFilterWhere(['like' ,'name', $nombres[$j]])
                            ->andFilterWhere(['like' ,'last_name', $apellidos[$j]])
                            ->one();
                        if ($instr) {
                            // echo "si existe";
                            $instr_sub = new InstructorSubject();
                            $instr_sub->id_instructor = $instr->id;
                            $instr_sub->id_subject = $newSubject->id;
                            $instr_sub->save();
                        }else{
                            // echo "no existe";
                            $profeError[] = $nombres[$j]." ".$apellidos[$j];
                        }
                    }
                }
            }

                    echo "Los siguientes profesores no se encontraron en la base de datos:";
                    echo '<br/>';
                    // echo($profeError);
                    echo '<br/>';

                    foreach($profeError as $result) {
                        echo $result, '<br>';
                    }

        }
        catch(Exeption $e) {
            die('Error loading file: '.$e->getMessage());
        }

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
