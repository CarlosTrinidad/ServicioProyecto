<?php

namespace app\controllers;

use Yii;
use app\models\Semester;
use app\models\Schedule;
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
use app\models\Room;

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
      $objPHPExcel = new \PHPExcel();
      $numsheet=5;

      for ($sheetId=0; $sheetId<$numsheet; $sheetId++){



      $objPHPExcel->createSheet($sheetId);
      $objPHPExcel->setActiveSheetIndex($sheetId);
        switch ($sheetId) {
        case '0': $objPHPExcel->setActiveSheetIndex($sheetId);
                  $this->Profesores($objPHPExcel);
                  break;


        case '1':
                  // Rename worksheet
                  $objPHPExcel->setActiveSheetIndex($sheetId);
                  $this->Salones($objPHPExcel);
                  break;

        case '2':
                  $objPHPExcel->setActiveSheetIndex($sheetId);
                  $this->Obli($objPHPExcel);

                  break;
       case '3':
                  $objPHPExcel->setActiveSheetIndex($sheetId);
                  $this->Opt($objPHPExcel);

                  break;

        case '4':
                  $objPHPExcel->setActiveSheetIndex($sheetId);
                  $this->Posgrado($objPHPExcel);
                  break;
      }


}
      $objPHPExcel->removeSheetByIndex($numsheet);

      $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      // Forzar descarga
      // $objWriter->save('php://output');
      $objWriter->save('MyExcel2.xlsx');

  }











  public function Obli($objPHPExcel){
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
        }
      // Mas estilos
      $sheet->getStyle('K3:L'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('M3:N'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('O3:P'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('Q3:R'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('S3:T'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('U3:V'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('A2:V'.$row)->applyFromArray($style2);
  }

  public function Opt($objPHPExcel){
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
      $sheet->setTitle('Optatiivas-Libres');
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
      $asignaturas = Subject::find()->where(['type' => 'OPT-LIBRE'])->orderBy('name')->all();
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
        }
      // Mas estilos
      $sheet->getStyle('K3:L'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('M3:N'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('O3:P'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('Q3:R'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('S3:T'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
      $sheet->getStyle('U3:V'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
      $sheet->getStyle('A2:V'.$row)->applyFromArray($style2);
  }










  public function Profesores($objPHPExcel){
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
    $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(60);
        //Estilo celdas
       $styleArray = array(
    'borders' => array(
      'allborders' => array(
          'style' => \PHPExcel_Style_Border::BORDER_THIN,
      ),
    ),
    'alignment' => array('vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,),
    );

       $styleTitles = array(
          'font' => array('bold'  => true,
                          'size'  => 12,
                          'name'  => 'Calibri'),
          );


       $styleRoomTitles = array(
          'font' => array('bold'  => true,
                          'size'  => 24,
                          'name'  => 'Calibri',
                          'color' => array('rgb' => 'FFFFFF')),
          'borders' => array(
      'allborders' => array(
          'style' => \PHPExcel_Style_Border::BORDER_THIN,
      ),
    ),
          );
  $styleArrayBorder = array(
    'borders' => array(
      'allborders' => array(
        'style' => \PHPExcel_Style_Border::BORDER_NONE,
        'color' => array('argb' => 'FFFF0000'),
      ),
    ),
    'fill' => array(
              'type' => \PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'FFFFFF'),
          ),
  );

    //Variable para almacenar la fila actual
    $currentRow = 4;
    $days = array(1=>'E',2=>'F',3=>'G',4=>'H',5=>'I',6=>'J');
    //Salón de prueba
    $room = Room::findOne(9);
    $rooms = Room::find()->orderBy('room')->all();
    //Profesores
    $instructors = Instructor::find()->orderBy('last_name')->all();

    //Creación del horario
    $schedule[0][0] = " ";
    $schedule[0][1] = " ";

    $schedule[0][2] = "Lunes";
    $schedule[0][3] = "Martes";
    $schedule[0][4] = "Miércoles";
    $schedule[0][5] = "Jueves";
    $schedule[0][6] = "Viernes";
    $schedule[0][7] = "Sábado";
    $hours = [];
    $intervals = Schedule::find()->all();
    $c=sizeof($schedule[0]);
    // Desde aquí se crea el horario

    foreach ($intervals as $interval) {
      $hours[] = substr($interval->schedule,0,5);
    }
    $hourLength = count($hours) + 1;

     //-----------------------------------------------------------------------Se crea el horario por profesor---------------------------------------------------
     foreach ($instructors as $instructor) {
       # code...
      // $schedule[0][0] = $instructor->name." ".$instructor->last_name;
       // ponemos las horas en cada horario
    for ($i=0; $i <  count($hours) - 1; $i++) {
     for ($j=0; $j < $c ; $j++) {
        if($j==0){
        $schedule[$i+1][$j] = $hours[$i];
        } else{
          if($j==1){$schedule[$i+1][$j] = $hours[$i+1];}
          else{$schedule[$i+1][$j] = " ";}

        }
     }
    }


     // Se establecen las clases dentro del horario
    $f=sizeof($schedule);
     for($i=0;$i<$f;$i++){
    if($i>0){
       if($i%2!=0){
          $hs = 'C'.($i+$currentRow).':'.'D'.($i+$currentRow);
          $objPHPExcel->getActiveSheet()->getStyle($hs)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F2F2F2');
       }
       }}


    foreach($instructor->subjects as $subject)
      {
  foreach ($subject->classes as $class) {
    # ya tenemos las clases de cada profesor
     # code...
      for($i=0;$i<$f;$i++){
        $objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight(22);
       if($schedule[$i][0]==substr($class->time_start,0,5)){
         $teachers = $class->idSubject->instructorSubjects;
          foreach ($teachers as $teacher) {
              # code...
              $t[] = $teacher->idInstructor->name." ".$teacher->idInstructor->last_name;
          }
          //se pone formato al nombre del maestro
          $teacherNames = implode(' / ', $t);
          $data = $class->idSubject->name."\n".$class->idSubject->sp."\n".$class->idRoom->room."\n".$teacherNames;
          $schedule[$i][$class->day+1] = $data;
          $ini = $days[$class->day].($i+$currentRow);
          //$objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight(28);
       }
       if($schedule[$i][1]==substr($class->time_end,0,5)){
          $fin = $days[$class->day].($i+$currentRow);
          if(strlen($class->idSubject->name)>=32 or strlen($teacherNames)>=32 ){
            //en esta parte se ajusta el alto de las filas
            $currentRowSize = strlen($class->idSubject->name)  + strlen($teacherNames);
            $newRowSize = round(($currentRowSize/32),0, PHP_ROUND_HALF_DOWN);
            $objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight((22*$newRowSize));
          }
       }
      }
      //Creamos el rango del merge y hacemos el merge para cada clase dentro del horario
      $range = $ini.':'.$fin;
      $objPHPExcel -> getActiveSheet()->mergeCells($range);
      $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle($range)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CFFFFCC');
     //variables usadas
      unset($t);
  }
      }
  //----------------------------------Se pone el formato de colores para cada horario--------------------------------------------------------
      $rangeName = 'B'.($currentRow+1).':'.'B'.($currentRow+$hourLength-2);
      $teacherName = array($instructor->name." ".$instructor->last_name);
      $objPHPExcel -> getActiveSheet()->fromArray($teacherName,null,'B'.($currentRow+1));
      $objPHPExcel->getActiveSheet()->getStyle($rangeName)->getAlignment()->setTextRotation(90);
      $objPHPExcel -> getActiveSheet()->mergeCells($rangeName);
      $inicio = 'C'.$currentRow;
      $roomName = 'C'.$currentRow.':'.'D'.$currentRow;
      $infoBar =  'E'.$currentRow.':'.'J'.$currentRow;
      $scheduleArea = 'C'.$currentRow.':'.'J'.($currentRow+$hourLength-2);
      $hoursArea = 'C'.$currentRow.':'.'D'.($currentRow+$hourLength-2);
      $objPHPExcel -> getActiveSheet()->fromArray($schedule,null,$inicio);
      $objPHPExcel -> getActiveSheet()->mergeCells($roomName);
      $objPHPExcel->getActiveSheet()->getStyle($scheduleArea)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle($rangeName)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle($rangeName)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle($infoBar)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
      $objPHPExcel->getActiveSheet()->getStyle($rangeName)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C00000');
      $objPHPExcel->getActiveSheet()->getStyle($scheduleArea)->applyFromArray($styleArray);
      $objPHPExcel->getActiveSheet()->getStyle($infoBar)->applyFromArray($styleTitles);
      $objPHPExcel->getActiveSheet()->getStyle($rangeName)->applyFromArray($styleRoomTitles);
      $objPHPExcel->getActiveSheet()->getStyle($hoursArea)->applyFromArray($styleTitles);
      //eliminacion de bordes
      $whiteRange = 'A'.$currentRow.':'.'A'.($currentRow+$hourLength-2);
      $whiteRange2 = 'K'.$currentRow.':'.'K'.($currentRow+$hourLength-2);
      $whiteRange3 = 'B'.($currentRow-1).':'.'J'.($currentRow-1);

      $objPHPExcel->getActiveSheet()->getStyle($whiteRange)->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle($whiteRange2)->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle($whiteRange3)->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle($roomName)->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArrayBorder);
      $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($styleArrayBorder);


      $currentRow = $currentRow + $hourLength ;


     }//fin profesores

    //Set data
    $headerRooms = array('Horario - vista por Profesores');
    //Establecemos los valores dentro del excel
    $objPHPExcel -> getActiveSheet()->fromArray($headerRooms, null, 'C2');
    $sheet = $objPHPExcel -> getActiveSheet();
    //Configuraciones a la hoja
    $sheet->mergeCells('C2:J2');
    $objPHPExcel->getActiveSheet()->getStyle('C2:J2')->applyFromArray($styleTitles);
    $objPHPExcel->getActiveSheet()->getStyle('C2:J2')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(22);
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
    // $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(-1);


    // $sheet->mergeCells('B4:C4');
    //Renombramos la hoja de estilos
    $sheet ->setTitle('Profesores');
    //Estilos
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C4:J32')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF99');

  }


















  public function Salones($objPHPExcel){
  $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
  $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(60);
      //Estilo celdas
     $styleArray = array(
  'borders' => array(
    'allborders' => array(
        'style' => \PHPExcel_Style_Border::BORDER_THIN,
    ),
  ),
  'alignment' => array('vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,),
  );

     $styleTitles = array(
        'font' => array('bold'  => true,
                        'size'  => 12,
                        'name'  => 'Calibri'),
        );


     $styleRoomTitles = array(
        'font' => array('bold'  => true,
                        'size'  => 12,
                        'name'  => 'Calibri',
                        'color' => array('rgb' => 'FFFFFF')),
        );

  //Variable para almacenar la fila actual
  $currentRow = 4;
  $days = array(1=>'D',2=>'E',3=>'F',4=>'G',5=>'H',6=>'I');
  //Salón de prueba
  $room = Room::findOne(9);
  $rooms = Room::find()->orderBy('room')->all();

  //Creación del horario
  $schedule[0][0] = " ";
  $schedule[0][1] = " ";
  $schedule[0][2] = "Lunes";
  $schedule[0][3] = "Martes";
  $schedule[0][4] = "Miércoles";
  $schedule[0][5] = "Jueves";
  $schedule[0][6] = "Viernes";
  $schedule[0][7] = "Sábado";
  $hours = [];
  $intervals = Schedule::find()->all();
  $c=sizeof($schedule[0]);
  // Desde aquí se crea el horario

  foreach ($intervals as $interval) {
    $hours[] = substr($interval->schedule,0,5);
  }
  $hourLength = count($hours) + 1;



  //para cada salón se crea un nuevo horario
  foreach ($rooms as $room) {
  $schedule[0][0] = $room->room;
  // ponemos las horas en cada horario
  for ($i=0; $i <  count($hours) - 1; $i++) {
   for ($j=0; $j < $c ; $j++) {
      if($j==0){
      $schedule[$i+1][$j] = $hours[$i];
      } else{
        if($j==1){$schedule[$i+1][$j] = $hours[$i+1];}
        else{$schedule[$i+1][$j] = " ";}

      }
   }
  }
  // Se establecen las clases dentro del horario
  $f=sizeof($schedule);
  $classes = $room->classes;
  for($i=0;$i<$f;$i++){
  if($i>0){
     if($i%2!=0){
        $hs = 'B'.($i+$currentRow).':'.'C'.($i+$currentRow);
        $objPHPExcel->getActiveSheet()->getStyle($hs)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F2F2F2');
     }
     }}

  foreach ($classes as $class) {
    # code...
    for($i=0;$i<$f;$i++){
      $objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight(22);
     if($schedule[$i][0]==substr($class->time_start,0,5)){
      //se obtienen las materias de cada maestro
        $teachers = $class->idSubject->instructorSubjects;
        foreach ($teachers as $teacher) {
            # code...
            $t[] = $teacher->idInstructor->name." ".$teacher->idInstructor->last_name;
        }
        //se pone formato al nombre del maestro
        $teacherNames = implode(' / ', $t);
        $data = $class->idSubject->name."\n".$class->idSubject->sp."\n".$class->idRoom->room."\n".$teacherNames;
        $schedule[$i][$class->day+1] = $data;
        $ini = $days[$class->day].($i+$currentRow);
        //$objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight(28);
     }
     if($schedule[$i][1]==substr($class->time_end,0,5)){
        $fin = $days[$class->day].($i+$currentRow);
        if(strlen($class->idSubject->name)>=32 or strlen($teacherNames)>=32 ){
          //en esta parte se ajusta el alto de las filas
          $currentRowSize = strlen($class->idSubject->name) + strlen($teacherNames);
          $newRowSize = round(($currentRowSize/32),0, PHP_ROUND_HALF_DOWN);
          $objPHPExcel->getActiveSheet()->getRowDimension(($i+$currentRow))->setRowHeight((22*$newRowSize));
        }
     }
    }
    //Creamos el rango del merge y hacemos el merge para cada clase dentro del horario
    $range = $ini.':'.$fin;
    $objPHPExcel -> getActiveSheet()->mergeCells($range);
    $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle($range)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CFFFFCC');
   //variables usadas
    unset($t);
  }

  //----------------------------------Se pone el formato de colores para cada horario--------------------------------------------------------
    $inicio = 'B'.$currentRow;
    $roomName = 'B'.$currentRow.':'.'C'.$currentRow;
    $infoBar =  'D'.$currentRow.':'.'I'.$currentRow;
    $scheduleArea = 'B'.$currentRow.':'.'I'.($currentRow+$hourLength-2);
    $hoursArea = 'B'.$currentRow.':'.'C'.($currentRow+$hourLength-2);
    $objPHPExcel -> getActiveSheet()->fromArray($schedule,null,$inicio);
    $objPHPExcel -> getActiveSheet()->mergeCells($roomName);
    $objPHPExcel->getActiveSheet()->getStyle($scheduleArea)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($infoBar)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    $objPHPExcel->getActiveSheet()->getStyle($roomName)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C00000');
    $objPHPExcel->getActiveSheet()->getStyle($scheduleArea)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle($infoBar)->applyFromArray($styleTitles);
    $objPHPExcel->getActiveSheet()->getStyle($roomName)->applyFromArray($styleRoomTitles);
    $objPHPExcel->getActiveSheet()->getStyle($hoursArea)->applyFromArray($styleTitles);
    $currentRow = $currentRow + $hourLength ;
  }


  //Set data
  $headerRooms = array('Horario - vista por Salones');
  //Establecemos los valores dentro del excel
  $objPHPExcel -> getActiveSheet()->fromArray($headerRooms, null, 'B2');
  $sheet = $objPHPExcel -> getActiveSheet();
  //Configuraciones a la hoja
  $sheet->mergeCells('B2:I2');
  $objPHPExcel->getActiveSheet()->getStyle('B2:I2')->applyFromArray($styleTitles);
  $objPHPExcel->getActiveSheet()->getStyle('B2:I2')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
  $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
  // $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(-1);


  // $sheet->mergeCells('B4:C4');
  //Renombramos la hoja de estilos
  $sheet ->setTitle('Salones');
  //Estilos
  $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('B4:I32')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('B2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF99');

  }








public function Posgrado($objPHPExcel){
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
  $style1 = array(
      'font' => array('bold'  => true,
                      'size'  => 9,
                      'name'  => 'Arial'),
      'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
      );
  $hearderPosgrado = array(
      'No.',
      'Asignatura',
      'PE',
      'NOMBRE(S)',
      'Hr.Pres',
      'Nr N/P',
      'LUNES',
      '',
      'MARTES',
      '',
      'MIÉRCOLES',
      '',
      'JUEVES',
      '',
      'VIERNES',
      '',);
      $header2Posgrado = array('Salón','Horario','Salón','Horario','Salón','Horario','Salón','Horario','Salón','Horario');

// Fill worksheet from values in array
  $objPHPExcel->getActiveSheet()->fromArray($hearderPosgrado, null, 'A1');
  $objPHPExcel->getActiveSheet()->fromArray($header2Posgrado, null, 'G2');
  $sheetPosgrado = $objPHPExcel->getActiveSheet();
  $sheetPosgrado->mergeCells('G1:H1');
  $sheetPosgrado->mergeCells('I1:J1');
  $sheetPosgrado->mergeCells('K1:L1');
  $sheetPosgrado->mergeCells('M1:N1');
  $sheetPosgrado->mergeCells('O1:P1');

  // Rename worksheet
  $sheetPosgrado->setTitle('Posgrado');
  // Add style
  $hearderPosgrado = 'G1:P1';
  $sheetPosgrado->getStyle('G1:P2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

  // $sheet->getStyle($header)->applyFromArray($style);
  $objPHPExcel->getActiveSheet()->freezePane('D2');
  $sheetPosgrado->getStyle('A1:P2')->applyFromArray($style1);
  // Set AutoSize for asignaturas and email modalidad
  $sheetPosgrado->getColumnDimension('A')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('B')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('C')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('D')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('E')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('F')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('G')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('H')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('I')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('J')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('K')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('L')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('M')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('N')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('O')->setAutoSize(true);
  $sheetPosgrado->getColumnDimension('P')->setAutoSize(true);

  $asignaturasP = new Subject();
  $asignaturasP = Subject::find()->where(['type' => 'POSGRADO'])->orderBy('sp')->all();
  $sheetDataP = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  $highestRowP = $sheetPosgrado->getHighestRow();

  $row = 3;
  $i=0;
  foreach ($asignaturasP as $posgrado) {
      // $highestRow = $objPHPExcel->getSheet(0)->getHighestRow();
      // print_r($highestRow);
      $i=$i+1;
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$i);

      $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$posgrado->name);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,(empty($posgrado->sp))?'':$posgrado->sp);

      $profs = $posgrado->instructorSubjects;
      foreach ($profs as $value) {
        // print_r($value->idInstructor->name);
        $nameVal = $sheetPosgrado->getCell('D'.$row)->getValue();
        //print_r($nameVal);
        if($nameVal === NULL || $nameVal === '') {
          $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,(empty($value->idInstructor->name))?'':$value->idInstructor->name.' '.$value->idInstructor->last_name);
        } else {
          $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,(empty($value->idInstructor->name))?'':$nameVal.', '.$value->idInstructor->name.' '.$value->idInstructor->last_name);
        }
      }

      $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,(empty($posgrado->hour_pre))?'':$posgrado->hour_pre);
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,(empty($posgrado->nr_np))?'':$posgrado->nr_np);


      //clases
      $clases = new Classes();
      $clases = Classes::find()->where(['id_subject' => $posgrado->id])->all();
      foreach ($clases as $clase) {

        switch ($clase->day) {
          case '1':
            // Lunes
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
            break;
          case '2':
            // Martes
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
            break;
          case '3':
            // Miercoles
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
            break;
          case '4':
            // Jueves
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
            break;
          case '5':
            // Viernes
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,(empty($clase->id_room))?'':$clase->idRoom->room);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,(empty($clase->time_start))?'':$clase->time_start." - ".$clase->time_end);
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
  $sheetPosgrado->getStyle('G3:G'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
  $sheetPosgrado->getStyle('H3:H'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
  $sheetPosgrado->getStyle('I3:I'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
  $sheetPosgrado->getStyle('J3:J'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
  $sheetPosgrado->getStyle('K3:K'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
  $sheetPosgrado->getStyle('L3:L'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
  $sheetPosgrado->getStyle('M3:M'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
  $sheetPosgrado->getStyle('N3:N'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
  $sheetPosgrado->getStyle('O3:O'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fefeb5');
  $sheetPosgrado->getStyle('P3:P'.$row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('bfd3a7');
  $sheetPosgrado->getStyle('A2:P'.$row)->applyFromArray($style2);
}
}
