<?php
use yii\helpers\registerCss;
use yii\helpers\Html;

//Se aplican estilos al horario
$this->registerCss("table {width: 100%; margin: 0 auto; border:#000000;} td.c{background-color:#FACC2E; color:#0B0B61; font-weight: bold;}  td{width: 13%; text-align: center;} td.rw{background-color:#0B0B61;color:#FACC2E} .emptyRow{ background-color:#FFFFFF;}");



echo "<h3>Horario Semestres<h3>";
if($semesters){
	//Variable para representar los dias
    $days = array(1,2,3,4,5);
    $dayDistribution = [];


	foreach ($semesters as $semester) {
		 $dayDistribution[] = "";
		 echo "<br><h4>".$semester->name."<br></h4>";
		# Obtenemos las materias para cada semestre
		  $subjects = $semester->subjects;
		# Creamos el horario de este semestre
		  $ini = createIni($interval);

// Crea el horario al tamaño adecuado

    foreach ($days as $day) {
     $cols = numCol($day,$subjects,$interval);
     $sub = groupByDay($day,$subjects);
     $section = createSection($cols,count($interval),$sub,$interval);
     $test = cutSchedule($section);
     $ini = mergeSections($ini,$test);
     $dayDistribution[] = sizeof($test[0]);
}
     $sch2 =  setLabels($dayDistribution,$ini);
     printSchedule($sch2);
     unset($dayDistribution);
	}

	}else{
		echo "No hay ningún semestre registrado";
	}


//función crea el inicio del horario
function createIni($interval){
$ini = [];
$index = count($interval);
for($i=0;$i<$index;$i++){
$ini[$i][0] = substr($interval[$i]->schedule,0,5);
}
return $ini;
}

//función calcula el numero máximo de columnas
function numCol($day,$subjects,$interval){
$collisions = 0;
$maxCol = 0;
$classes = groupByDay($day,$subjects);
foreach ($classes as $class1) {
    foreach ($classes as $class2) {
        //modificación
        if($class1!=$class2){
             $collision = isCollision($class1,$class2,$interval);
             if($collision) $collisions++;
        }
}
if($maxCol < $collisions) $maxCol = $collisions;
$collisions = 0;
}
return $maxCol+1;
}

//función agrupa classes por dia
function groupByDay($dayId,$subjects){
    $classes = array();
 foreach ($subjects as $subject) {
    foreach ($subject->classes as $class) {
        # code...
        if($class->day == $dayId) $classes[] = $class;
    }
    }
    return $classes;}

//función que crea la sección del horario por dia
function createSection($colNum,$rowsNum,$classes,$interval){
    $section = [];
for($i=0;$i<$rowsNum;$i++){
    for($j=0;$j<$colNum;$j++){
        $section[$i][$j] = " ";
    }
}

foreach ($classes as $class) {
    # code...
    insertClass($class,$section,$interval);
}


return $section;
}

function insertClass($class,&$section,$interval){
    $iniCol = 0;
    $set = false;
    $f=sizeof($section);
    $c=sizeof($section[0]);
    //Obtenemos el horario de la clase
    $startTime = $class->time_start;
    $endTime = $class ->time_end;
    // Establece la clase dentro de la sección
    while (!$set) {
        # code...
        if(isAvailable($startTime,$endTime,$iniCol,$section,$interval)){
        setClass($startTime,$endTime,$iniCol,$section,$class,$interval);
        $set = true;
        }else{
            $iniCol++;
        }
        if($iniCol>=$c){$set = true;}
    }
}

function isAvailable($startTime,$endTime,$col,&$section,$interval){
$available = true;
$hours = [];
foreach ($interval as $hour) {
    # code...
    $hours[] = $hour->schedule;
}
$iniTime = array_search($startTime, $hours);
$endTime = array_search($endTime, $hours);
for($i = $iniTime;$i<=$endTime;$i++){
if($section[$i][$col]!=" ")$available=false;
}
return $available;
}

function setClass($startTime,$endTime,$col,&$section,$class,$interval){
$hours = [];
$programas = array();
foreach ($interval as $hour) {
    # code...
    $hours[] = $hour->schedule;
}
  foreach ($class->idSubject->programSubjects as $program) {
                $programas[] = $program->idProgram->name;
            }
            $prog = implode(",", $programas);

$iniTime = array_search($startTime, $hours);
$endTime = array_search($endTime, $hours);
for($i = $iniTime;$i<=$endTime;$i++){
$section[$i][$col]=$class->id."]"."Materia: ".$class->idSubject->name."<br>"."Salón: ".$class->idRoom->room."<br>".$prog;
}
}

//función que recorta horario
function cutSchedule($section){
$newSchedule = [];
$empty = false;
$colNum=sizeof($section[0]);
$rows=sizeof($section);
$ccol = 1;
//echo "Columnas: ".$colNum." Filas: ".$rows." <br>";
while($ccol<$colNum and !$empty){
if(isEmpty($section,$ccol)){$empty = true;
}else{
    $ccol++;
}
}
//Guarda nuevo horario
for($j=0;$j<$ccol;$j++){
for($i=0;$i<$rows;$i++){
    $newSchedule[$i][$j] = $section[$i][$j];
}
}
return $newSchedule;
}

//Función une secciones
function mergeSections($sectionA,$sectionB){
$newSec = [];
$newSec = $sectionA;
$f=sizeof($newSec);
$c=sizeof($newSec[0]);
$newcols = sizeof($sectionB[0]);
for($j=0;$j<$newcols;$j++){
 for($i=0;$i<$f;$i++){
 $newSec[$i][$c+$j] = $sectionB[$i][$j];
 }
}
return $newSec;
}

function isEmpty($section,$col){
$empty = true;
$rows=sizeof($section);
for($i=0;$i<$rows;$i++){
if($section[$i][$col]!=" "){
    $empty = false;
}
}
return $empty;
}


//Función que imprime los horarios
function printSchedule($matrix){
    $f=sizeof($matrix);
    $c=sizeof($matrix[0]);
    echo '<table  border="1" width: 100% class="ScheduleTable">';
for($i=0;$i<$f;$i++){
    echo "<tr>";
    for($j=0;$j<$c;$j++){
        if($i==0 or $j==0){
          if($j==0){
            echo '<td class="rw">';
            echo $matrix[$i][$j];
            echo "</td>";
           }else{
            if($matrix[$i][$j-1]!=$matrix[$i][$j]){
                //Imprimimos el colspan
                $size = horizontalCount($j,$matrix);
                echo '<td colspan="'.$size.'" class="rw">';
                echo $matrix[$i][$j];;
                echo "</td>";
            }
           }
             }
            else{
            if($matrix[$i-1][$j]!=$matrix[$i][$j] and $matrix[$i][$j]!=" "){
            $size = getSubjectLength($matrix,$i,$j);
            echo '<td rowspan="'.$size.'" class="c">';
            // echo $matrix[$i][$j];//$matrix[$i][$j];

          $beforeColon = substr($matrix[$i][$j], strpos($matrix[$i][$j],']')+1);
          $id_class = substr($matrix[$i][$j], 0 , strpos($matrix[$i][$j],']'));
          echo $beforeColon;

            echo "</br>";
            if (!Yii::$app->user->isGuest) {
            echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['classes/update', 'id' => $id_class, 'return' => 'yes' ]);
            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['classes/delete', 'id' => $id_class, 'return' => 'yes'], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                'method' => 'post',
                            ],
                        ]);
                      }
            echo "</td>";
            }else{
                if($matrix[$i][$j]==" "){
            echo '<td class="emptyRow">';
            if (!Yii::$app->user->isGuest) {
            echo Html::a('<span class="glyphicon glyphicon-plus"></span>', ['classes/create', 'day' => $j, 'time_start' => $matrix[$i][0].":00", 'return' => 'yes' ]);
            }
            echo $matrix[$i][$j];
            echo "</td>";}
            } }
    }
    echo "</tr>";
}
echo "</table>";
}

function horizontalCount($col,$matrix){
    $size = 1;
    $c=sizeof($matrix[0]);
    for($j=$col+1;$j<$c;$j++){
    if($matrix[0][$col]==$matrix[0][$j])$size++;
    }
    return $size;
}

function setLabels($labels,$schedule){
$dias = array(1=>"Lunes",2=>"Martes",3=>"Miercoles",4=>"Jueves",5=>"Viernes");
$finalSch = [];
$f=sizeof($schedule);
$c=sizeof($schedule[0]);
for($k=0;$k<$c;$k++){$finalSch[0][$k]="";}
// Merge matriz and labels
    for ($i=0; $i < $f ; $i++) {
        # code...
        for ($j=0; $j <$c ; $j++) {
            # code...
            $finalSch[$i+1][$j]=$schedule[$i][$j];
        }
    }
//set labels over schedule
    $col = 0;
    foreach ($labels as $key=>$label) {
        # code...
        for($j=1;$j<=$label;$j++){
         $col++;
         $finalSch[0][$col] = $dias[$key];
        }

    }
return $finalSch;
}


//función detecta choque entre dos clases
function isCollision($class1,$class2,$interval){
$hours = [];
//variables para guardar horas de cada clase
$c1 = array();
$c2 = array();
//banderas
$start = 0;
$stop = 0;
    //obtenemos las horas de la base de datos
foreach ($interval as $hour) {
    $hours[]  = $hour->schedule;
}
// manipulamos las horas
$size = count($hours);
for($j=0;$j<$size;$j++){
   // echo $hours[$j]."<br>";
    if($class1->time_start == $hours[$j])$start = 1;
    if($class1->time_end == $hours[$j]){
       $stop = 1;
       array_push($c1,$j+1);
    }
    if($start && !$stop) array_push($c1,$j+1);
}
$start = 0;
$stop = 0;

for($j=0;$j<$size;$j++){
   // echo $hours[$j]."<br>";
    if($class2->time_start == $hours[$j])$start = 1;
    if($class2->time_end == $hours[$j]){
       $stop = 1;
       array_push($c2,$j+1);
    }
    if($start && !$stop) array_push($c2,$j+1);
}


echo "<br>";
$result = array_intersect($c1,$c2);
if(empty($result)) return false;
else return true;
}

//Esta funcion obtiene la longitud de cada clase
function getSubjectLength($matrix,$row,$column){
$f=sizeof($matrix);
$counter = 1;
$stopCounting = false;
	for($i=$row+1;$i<$f;$i++){
        if($matrix[$i][$column]!=$matrix[$i-1][$column]) $stopCounting= true;
		if($matrix[$i][$column]==$matrix[$row][$column] and $matrix[$i][$column]==$matrix[$i-1][$column] and !$stopCounting)$counter++;
	}
	return $counter;
}

?>
