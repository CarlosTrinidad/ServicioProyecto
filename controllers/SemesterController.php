<?php

namespace app\controllers;

use Yii;
use app\models\Semester;
use app\models\SemesterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Subject;
use app\models\Classes;
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
          'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'only' => ['create','update','delete'],
                        'rules' => [
                            // allow authenticated users
                            [
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                            // everything else is denied
                        ],
                    ],
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

    public function actionExportExcel(){
                /** Include PHPExcel */
                // header('Content-Type: application/vnd.ms-excel');
                // header('Content-Disposition: attachment;filename="MyExcel.xlsx"');
                // header('Cache-Control: max-age=0');
                echo "<H1>Data</H1>";

        // Here is the sample array of data
        $hearderAsignaturas = array(
            'Asignatura',
            'PE',
            '#',
            'NOMBRE(S)',
            'APELLIDOS',
            'Hr.Pres',
            'Nr N/P',
            'SEMESTRE',
            'MODELO',
            'CUPO MAX',
            'LUNES',
            '',
            'MARTES',
            '',
            'MIÉRCOLES',
            '',
            'JUEVES',
            '',
            'VIERNES',
            '',
            'SÁBADO',
            '');
            $header2 = array('Salón','Horario','Salón','Horario','Salón','Horario','Salón','Horario','Salón','Horario','Salón','Horario');
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();

        // Fill worksheet from values in array
        $objPHPExcel->getActiveSheet()->fromArray($hearderAsignaturas, null, 'A1');
        $objPHPExcel->getActiveSheet()->fromArray($header2, null, 'K2');
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->mergeCells('K1:L1');
        $sheet->mergeCells('M1:N1');
        $sheet->mergeCells('O1:P1');
        $sheet->mergeCells('Q1:R1');
        $sheet->mergeCells('S1:T1');
        $sheet->mergeCells('U1:V1');

        // Rename worksheet
        $sheet->setTitle('Licenciatura');
        // Add style
        $header = 'K1:V1';
        $sheet->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b1b1b1');
        $sheet->getStyle('K2:V2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b1b1b1');
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
        $sheet->getStyle($header)->applyFromArray($style);
        $sheet->getStyle('K2:V2')->applyFromArray($style);
        // Set AutoSize for asignaturas and email modalidad
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);


        $asignaturas = new Subject();
        $asignaturas = Subject::find()->orderBy('name')->all();
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $highestRow = $sheet->getHighestRow();

        //Fila de la primera asignatura

        // print_r($highestRow);
        // $objPHPExcel->getActiveSheet()->setCellValue('A'.($highestRow+4), 'cell value here');


        // $objPHPExcel->getActiveSheet()->fromArray($hearderAsignaturas, null, 'A1');
        $row = 3;
        foreach ($asignaturas as $asignatura) {
            // $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();
            // print_r($highestRow);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$asignatura->name);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,(empty($asignatura->sp))?'':$asignatura->sp);
            // $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,(empty($asignatura->sp))?'':'');

            $profs = $asignatura->instructorSubjects;
            foreach ($profs as $value) {
              // print_r($value->idInstructor->name);
              $nameVal = $sheet->getCell('D'.$row)->getValue();
              print_r($nameVal);
              if($nameVal === NULL || $nameVal === '') {
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,(empty($value->idInstructor->name))?'':$value->idInstructor->name);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,(empty($value->idInstructor->last_name))?'':$value->idInstructor->last_name);
              } else {
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,(empty($value->idInstructor->name))?'':$nameVal.'/'.$value->idInstructor->name);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,(empty($value->idInstructor->last_name))?'':$nameVal.'/'.$value->idInstructor->last_name);
              }
            }

            // $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,(empty($asignatura->sp))?'':$asignatura->sp);
            // $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,(empty($asignatura->sp))?'':$asignatura->sp);
            // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,(empty($asignatura->sp))?'':$asignatura->sp);

            //Modelo
            $models = ['0' => 'MEFI','1' => 'MEyA', '2'=> 'MEFI-MEYA'];
            print_r($models[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,(empty($models[$asignatura->model]))?'':$models[$asignatura->model]);
            // $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,(empty($models[$asignatura->model]))?'':$models[$asignatura->model]);

            //clases
            $clases = new Classes();
            $clases = Classes::find()->where(['id_subject' => $asignatura->id])->all();
            foreach ($clases as $clase) {

              switch ($clase->day) {
                case '1':
                  // Lunes
                  $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;
                case '2':
                  // Martes
                  $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;
                case '3':
                  // Miercoles
                  $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;
                case '4':
                  // Jueves
                  $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('R'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;
                case '5':
                  // Viernes
                  $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('T'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;
                case '6':
                  // Sabado
                  $objPHPExcel->getActiveSheet()->setCellValue('U'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
                  $objPHPExcel->getActiveSheet()->setCellValue('V'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
                  break;

                default:
                  # code...
                  break;
              }
              // print_r($clase->idSubject->name);
            }
            $row++;


            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
        }


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // Forzar descarga
        // $objWriter->save('php://output');
        $objWriter->save('MyExcel.xlsx');
    }

}
