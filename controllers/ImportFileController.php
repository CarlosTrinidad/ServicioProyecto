<?php

namespace app\controllers;

use Yii;
use app\models\ImportFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\helpers\Html;
use app\models\Subject;
use app\models\Instructor;
use app\models\InstructorSubject;
use app\models\ProgramSubject;
use app\models\SubjectSemester;
use app\models\Semester;
use app\models\StudyProgram;


class ImportFileController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $model = new ImportFile();

        if (Yii::$app->request->isPost) {
            $model->fileImport = UploadedFile::getInstance($model, 'fileImport');
            if ($model->upload()) {
                // file is uploaded successfully
                $this->actionImportExcel();
                return $this->render('view', [
                ]);
                // return $this->redirect(['view']);
                // return true;
            }
        }

        return $this->render('index', ['model' => $model]);
    }

    //     public function actionView()
    // {
    //     // Yii::$app->session->setFlash('success', "Your message to display");
    //     return $this->render('view', [
    //     ]);
    // }


     public function actionImportExcel()
     {

        Yii::$app->session->setFlash('success', "Holaaaaaa");

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        $inputFile = "./files/import.xlsx";
        $profError = array();
        try{
            // Fifth sheet (PROFESORES)
            $i=3;
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $sheetnames = $objReader->listWorksheetNames($inputFile);
            $objReader->setLoadSheetsOnly($sheetnames[$i]);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFile);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();

            $newTotal = 0;
            for ($row=2; $row <= $highestRow ; $row++) {
                // Se verifica si existe el instructor
                $newInstructor = new Instructor();
                $newInstructor = Instructor::find()
                    ->andFilterWhere(['like' ,'name', $sheetData[$row]['C']])
                    ->andFilterWhere(['like' ,'last_name', $sheetData[$row]['D']])
                    ->one();
                if ($newInstructor == false) {
                    $newInstructor = new Instructor();
                    $newInstructor->name = $sheetData[$row]['C'];
                    $newInstructor->last_name = $sheetData[$row]['D'];

                    if ($newInstructor->save()) {
                      $newTotal++;
                    }

                }
            }

            Yii::$app->session->setFlash('totalInstructors', $newTotal);

            //covertir MEFI en 1
            $modelos = array('0' => '', '1' => 'MEFI','2' => 'MEyA', '3'=> 'MEFI-MEyA');
            $programasEduc = StudyProgram::find()
                    ->asArray()
                    ->all();

            for ($i=0; $i <=4 ; $i++) {
                if ($i == 3 or $i == 2) {
                    continue;
                }


                $objReader->setLoadSheetsOnly($sheetnames[$i]);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($inputFile);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();

                $newTotal = 0;

                for ($row=2; $row <= $highestRow ; $row++) {
                    // $newSubject = new Subject();
                    // $newSubject = Subject::find()
                    //     ->andFilterWhere(['name' => $sheetData[$row]['B']])
                    //     ->andFilterWhere(['sp' => $sheetData[$row]['D']])
                    //     ->andFilterWhere(['model' => array_search($sheetData[$row]['M'],$modelos) ])
                    // ->andFilterWhere(['semester' => (int)str_replace("°", "", $sheetData[$row]['D']) ])
                    // ->andFilterWhere(['modality' => $sheetData[$row]['G']])
                    // ->filterWhere(['type' => $sheetData[$row]['B']])
                    // ->one();

                    // if ($newSubject == false) {
                        $newSubject = new Subject();
                        $newSubject->name = (string)$sheetData[$row]['B'];
                        $newSubject->sp = (string)$sheetData[$row]['D'];
                        // echo $sheetData[$row]['M'];
                        $modelModify = str_replace("MEYA", "MEyA", $sheetData[$row]['M']);

                        if (array_search($modelModify,$modelos) == false) {
                            $newSubject->model = 0;
                        }else{
                            $newSubject->model = array_search($modelModify,$modelos);
                        }

                        // $cleanSemester = str_replace("°", "", $sheetData[$row]['D']);
                        // echo $newSubject->id;
                        // echo $newSubject->name;
                        // echo substr($sheetData[$row]['L'], 0, strspn($sheetData[$row]['L'], "0123456789"));
                        // echo '<br/>';
                        // if ($sheetData[$row]['G'] == null) {
                            $newSubject->modality = "-";
                        // }else{
                        //     $newSubject->modality = (string)$sheetData[$row]['G'];
                        // }
                        $newSubject->type = (string)trim($sheetnames[$i],'S');
                        if($newSubject->save()){
                            $newTotal++;
                            $newSubject->save();
                        }else{
                            // print_r($newSubject->name);
                            // echo '<br/>';

                        }

                    // Asignar SubjectSemester (CC1 MEFI)
                    $programas_opt = array("A", "IC", "CC", "IS", "E","M","MCC","MCM","EE");
                    foreach($programas_opt as $result_programa) {
                      $pos = strpos($sheetData[$row]['D'], $result_programa);
                      if ($pos === 0) {
                        $newSubSemester = new SubjectSemester();
                        $newProgramSubject = new ProgramSubject();

                        $resultStudy = StudyProgram::find()
                            ->andFilterWhere(['name' => $result_programa])
                            ->one();
                        $newProgramSubject->id_subject = $newSubject->id;
                        $newProgramSubject->id_program =$resultStudy->id;
                        $newProgramSubject->save();

                        $searchSemester = $result_programa.substr($sheetData[$row]['L'], 0, strspn($sheetData[$row]['L'], "0123456789"))." ".$modelos[$newSubject->model];
                        $newSemester = new Semester();
                        $newSemester = Semester::find()
                            ->andFilterWhere(['name' => $searchSemester])
                            ->one();
                        if ($newSemester) {
                          $newSubSemester->subject_id = $newSubject->id;
                          $newSubSemester->semester_id = $newSemester->id;
                          $newSubSemester->save();
                        }
                      }
                    }


                    // Identificar si las materia es impartida por multiples profesores
                    $apellidos = array();
                    $numProfesores = substr_count($sheetData[$row]['G'], '/');
                    if ($numProfesores > 0) {
                        $posInicio = 0;
                        for ($m=0; $m <= $numProfesores ; $m++) {
                            $posFinal = strpos($sheetData[$row]['G'], '/', $posInicio);
                                if($posFinal == false){
                                    $posFinal = strlen($sheetData[$row]['G']);
                                }
                            $apellidos[] = substr($sheetData[$row]['G'],$posInicio ,$posFinal - $posInicio);
                            $posInicio = $posFinal+1;
                        }
                    }else {
                        $nombres[] = $sheetData[$row]['F'];
                        $apellidos[] = $sheetData[$row]['G'];
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
                            $subjectError[] = $newSubject->name;
                            $profError[] = $newSubject->name." - ".$apellidos[$j];
                        }
                    }
                }
                        Yii::$app->session->setFlash('total'.$sheetnames[$i], $newTotal);

            }

                    foreach($profError as $clave => $valor) {
                        Yii::$app->session->addFlash('errorProf', $valor);
                    }
        }
        catch(Exeption $e) {
            die('Error loading file: '.$e->getMessage());
        }

    }

}
