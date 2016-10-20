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

     /**
     * Import the Semester data based on import.xlsx.
     */   
    public function actionImportExcel(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        $inputFile = "./files/import.xlsx";
        $profeError = array();

        try{
            // Fifth sheet (PROFESORES)
            $i=4;
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $sheetnames = $objReader->listWorksheetNames($inputFile);
            $objReader->setLoadSheetsOnly($sheetnames[$i]);
            print_r($sheetnames[$i]);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFile);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();

            for ($row=2; $row <= $highestRow ; $row++) { 

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

            for ($i=0; $i < 3 ; $i++) { 
                print_r($sheetnames[$i]);
                echo '<br/>';

                $objReader->setLoadSheetsOnly($sheetnames[$i]);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFile);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();

                for ($row=2; $row <= $highestRow ; $row++) { 

                $newSubject = new Subject();
                $newSubject = Subject::find()
                    ->andFilterWhere(['name' => $sheetData[$row]['B']])
                    ->andFilterWhere(['sp' => $sheetData[$row]['C']])
                    ->andFilterWhere(['model' => array_search($sheetData[$row]['H'],$modelos) ])
                    // ->andFilterWhere(['semester' => (int)str_replace("°", "", $sheetData[$row]['D']) ])
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

                        // $newSubject->semester = (int)str_replace("°", "", $sheetData[$row]['D']);

                        if ($sheetData[$row]['G'] == null) {
                            $newSubject->modality = "-";
                        }else{
                            $newSubject->modality = (string)$sheetData[$row]['G'];
                        }
                        $newSubject->type = (string)trim($sheetnames[$i],'S');
                        $newSubject->save();
                    }else{
                        continue;
                    }


                    //Si la materia es para cualquier materia
                    $programas_opt = array("A", "IC", "CC", "IS", "E","M");

                    if ($sheetData[$row]['C'] == 'FMAT' || $sheetData[$row]['C'] == 'Institucional') {
                        foreach($programasEduc as $result) {
                            if (in_array($result['name'], $programas_opt)) {
                                $prgm_sub = new ProgramSubject();
                                $prgm_sub->id_program = $result['id'];
                                $prgm_sub->id_subject = $newSubject->id;
                                $prgm_sub->save();
                            }
                        }
                    }else{
                    //Limpiar formato de PE
                        $words = $sheetData[$row]['C'];
                        $words = preg_replace('/[0-9]+/', '', $words);
                        $words = str_replace(array( '(', ')' ), '', $words);
                    // Buscar si en la columna PE existe en la BD
                        foreach($programasEduc as $result) {
                            if (strpos($words, $result['name']) === FALSE) {
                                continue;
                            }else{
                                $prgm_sub = new ProgramSubject();
                                $prgm_sub->id_program = $result['id'];
                                $prgm_sub->id_subject = $newSubject->id;
                                $prgm_sub->save();
                            }
                        }
                    }
                    

                    // Identificar si las materia es impartida por dos profesores
                    $pos = strpos($sheetData[$row]['N'], '/');
                    $pos2 = strpos($sheetData[$row]['O'], '/');
                    $nombres = array();
                    $apellidos = array();

                    if ($pos !== false) {
                        $nombres[] = substr($sheetData[$row]['N'],0,$pos);
                        $nombres[] = substr($sheetData[$row]['N'],$pos+1);
                        $apellidos[] = substr($sheetData[$row]['O'],0,$pos2);
                        $apellidos[] = substr($sheetData[$row]['O'],$pos2+1);
                    } else {
                        $nombres[] = $sheetData[$row]['N'];
                        $apellidos[] = $sheetData[$row]['O'];
                    }

                    // Search Instructor en BD y obtener su id
                    for ($j=0; $j < count($apellidos); $j++) { 
                        $instr = new Instructor();
                        $instr = Instructor::find()
                            ->andFilterWhere(['like' ,'last_name',trim($apellidos[$j])])
                            ->one();
                        if ($instr) {
                            // "si existe";
                            $instr_sub = new InstructorSubject();
                            $instr_sub->id_instructor = $instr->id;
                            $instr_sub->id_subject = $newSubject->id;
                            $instr_sub->save();
                        }else{
                            //  "no existe";
                            $profeError[] = $nombres[$j]." ".$apellidos[$j];
                        }
                    }
                }
            }

                    echo "Los siguientes profesores no se encontraron en la base de datos:";
                    echo '<br/>';

                    foreach($profeError as $result) {
                        echo $result, '<br>';
                    }
        }
        catch(Exeption $e) {
            die('Error loading file: '.$e->getMessage());
        }

    }
    
    public function actionExportExcel(){
                /** Include PHPExcel */
 
        // Here is the sample array of data
        $hearderAsignaturas = array(
            'Id',
            'Obligatoria/Optativa/Libre/Taller',
            'Asignatura',
            'Programa',
            'Semestre',
            'Modalidad',
            'Modelo',
            'Nombres',
            'Apellidos',
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado');
 
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();
        
        // Fill worksheet from values in array
        $objPHPExcel->getActiveSheet()->fromArray($hearderAsignaturas, null, 'A1');
        $sheet = $objPHPExcel->getActiveSheet();
        // Rename worksheet
        $sheet->setTitle('Asignaturas');
        // Add style
        $header = 'a1:o1';
        $sheet->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b1b1b1');
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
        $sheet->getStyle($header)->applyFromArray($style);
        // Set AutoSize for asignaturas and email modalidad
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        
        
        $asignatura = new Subject();
        $asignatura = Subject::find()->all();
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

        foreach ($asignatura as $key) {
            $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();
            print_r($highestRow);
            $sheetData[1]['C'] = $key->name;

            // for ($row=2; $row <= $highestRow ; $row++) { 
            //         $sheetData[$row]['C'] = $key->name;
            // }
        }
        // Save Excel 2007 file
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('MyExcel.xlsx');
    }

}
