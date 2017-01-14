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
        $sheet->getStyle('K1:V2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
        $style1 = array(
            'font' => array('bold'  => true,
                            'size'  => 9,
                            'name'  => 'Arial'),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
        $style2 = array(
            'font' => array('bold'  => false,
                            'size'  => 9,
                            'name'  => 'Arial'),
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );

        // $sheet->getStyle($header)->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $sheet->getStyle('A1:V2')->applyFromArray($style1);
        // Set AutoSize for asignaturas and email modalidad
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);


        $asignaturas = new Subject();
        $asignaturas = Subject::find()->where(['type' => 'Obligatorias'])->orderBy('name')->all();
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
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,(empty($asignatura->number))?'':$asignatura->number);

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

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,(empty($asignatura->hour_pre))?'':$asignatura->hour_pre);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,(empty($asignatura->nr_np))?'':$asignatura->nr_np);
            // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,(empty($asignatura->sp))?'':$asignatura->sp);

            //Modelo
            $models = ['0' => 'MEFI','1' => 'MEyA', '2'=> 'MEFI-MEYA'];
            print_r($models[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,(empty($models[$asignatura->model]))?'':$models[$asignatura->model]);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,(empty($asignatura->max_capacity))?'':$asignatura->max_capacity);


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
        }

        // Mas estilos
        $sheet->getStyle('K3:L'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
        $sheet->getStyle('M3:N'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
        $sheet->getStyle('O3:P'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
        $sheet->getStyle('Q3:R'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
        $sheet->getStyle('S3:T'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
        $sheet->getStyle('U3:V'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
        $sheet->getStyle('A2:V'.$row)->applyFromArray($style2);


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // Forzar descarga
        // $objWriter->save('php://output');
        $objWriter->save('MyExcel.xlsx');
    }

}
