
<h1>Esta es la vista de <?php echo $section;?></h1><br>

<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\registerCss;


// Este helper nos permite darle estilos a las tablas
$this->registerCss("table {width: 80%; margin: 0 auto; } td.c{background-color:#1cd9e6;}  td{width: 13%; text-align: center;} td.rw{background-color:#b9c9fe;} .emptyRow{ background-color:#e8edff;}");

// Solo se mostraran los horarios de los profesores que si tienen clases asignadas
foreach ($model as $instructor) {
        $idmaterias = getIdClasses($instructor->id,$subjectstoinstructors);
		$teacherClasses = getInstructorClasses($idmaterias,$clases);
        if($teacherClasses){
	    echo "<h4> Horario del profesor ".$instructor->name." ".$instructor->last_name."</h4> <br>";
	    $horario=setSchedule($interval);
	    setClassesIntoSchedule2($teacherClasses,$horario);
        echo "<br>";
        printMatrix($horario);
        echo "<br> <br>";
        //printMat($horario);
        unset($materias);
        unset($teacherClasses);}
		}

//Función que imprime los horarios
function printMatrix($matrix){
	$f=sizeof($matrix);
	$c=sizeof($matrix[0]);
	echo '<table  border="1" width: 100% class="ScheduleTable">';
for($i=0;$i<$f;$i++){
	echo "<tr>";
	for($j=0;$j<$c;$j++){
// <<<<<<< HEAD
		echo "<td>";
	echo $matrix[$i][$j];
		echo "</td>";
// =======
		if($i==0 or $j==0){
			echo '<td class="rw">';
	        echo $matrix[$i][$j];
		    echo "</td>";	}
		    else{
            if($matrix[$i-1][$j]!=$matrix[$i][$j] and $matrix[$i][$j]!=" "){
            $size = getSubjectLength($matrix,$i,$j);
            echo '<td rowspan="'.$size.'" class="c">';
	        echo $matrix[$i][$j];//$matrix[$i][$j];
		    echo "</td>";
            }else{
            	if($matrix[$i][$j]==" "){
            echo '<td class="emptyRow">';
	        echo $matrix[$i][$j];
		    echo "</td>";}
            } }
// >>>>>>> b0a001c9faad4ab679a5fae2392168fc2fe9cc85
	}
	echo "</tr>";
}
echo "</table>";
}

// <<<<<<< HEAD
//Esta función crea la tabla con los registros del maestro
function setSchedule(){
$schedules[0][0] = "Hora";
$schedules[0][1] = "Lunes";
$schedules[0][2] = "Martes";
$schedules[0][3] = "Miercoles";
$schedules[0][4] = "Jueves";
$schedules[0][5] = "Viernes";
$schedules[1][0] = "7:00";
$schedules[1][1] = " ";
$schedules[1][2] = " ";
$schedules[1][3] = " ";
$schedules[1][4] = " ";
$schedules[1][5] = " ";
$schedules[2][0] = "7:30";
$schedules[2][1] = " ";
$schedules[2][2] = " ";
$schedules[2][3] = " ";
$schedules[2][4] = " ";
$schedules[2][5] = " ";
$schedules[3][0] = "8:00";
$schedules[3][1] = " ";
$schedules[3][2] = " ";
$schedules[3][3] = " ";
$schedules[3][4] = " ";
$schedules[3][5] = " ";
$schedules[4][0] = "8:30";
$schedules[4][1] = " ";
$schedules[4][2] = " ";
$schedules[4][3] = " ";
$schedules[4][4] = " ";
$schedules[4][5] = " ";
$schedules[5][0] = "9:00";
$schedules[5][1] = " ";
$schedules[5][2] = " ";
$schedules[5][3] = " ";
$schedules[5][4] = " ";
$schedules[5][5] = " ";
$schedules[6][0] = "9:30";
$schedules[6][1] = " ";
$schedules[6][2] = " ";
$schedules[6][3] = " ";
$schedules[6][4] = " ";
$schedules[6][5] = " ";
$schedules[7][0] = "10:00";
$schedules[7][1] = " ";
$schedules[7][2] = " ";
$schedules[7][3] = " ";
$schedules[7][4] = " ";
$schedules[7][5] = " ";
$schedules[8][0] = "10:30";
$schedules[8][1] = " ";
$schedules[8][2] = " ";
$schedules[8][3] = " ";
$schedules[8][4] = " ";
$schedules[8][5] = " ";
$schedules[9][0] = "11:00";
$schedules[9][1] = " ";
$schedules[9][2] = " ";
$schedules[9][3] = " ";
$schedules[9][4] = " ";
$schedules[9][5] = " ";
$schedules[10][0] = "11:30";
$schedules[10][1] = " ";
$schedules[10][2] = " ";
$schedules[10][3] = " ";
$schedules[10][4] = " ";
$schedules[10][5] = " ";
$schedules[11][0] = "12:00";
$schedules[11][1] = " ";
$schedules[11][2] = " ";
$schedules[11][3] = " ";
$schedules[11][4] = " ";
$schedules[11][5] = " ";
$schedules[12][0] = "12:30";
$schedules[12][1] = " ";
$schedules[12][2] = " ";
$schedules[12][3] = " ";
$schedules[12][4] = " ";
$schedules[12][5] = " ";
$schedules[13][0] = "13:00";
$schedules[13][1] = " ";
$schedules[13][2] = " ";
$schedules[13][3] = " ";
$schedules[13][4] = " ";
$schedules[13][5] = " ";
$schedules[14][0] = "13:30";
$schedules[14][1] = " ";
$schedules[14][2] = " ";
$schedules[14][3] = " ";
$schedules[14][4] = " ";
$schedules[14][5] = " ";
$schedules[15][0] = "14:00";
$schedules[15][1] = " ";
$schedules[15][2] = " ";
$schedules[15][3] = " ";
$schedules[15][4] = " ";
$schedules[15][5] = " ";
$schedules[16][0] = "14:30";
$schedules[16][1] = " ";
$schedules[16][2] = " ";
$schedules[16][3] = " ";
$schedules[16][4] = " ";
$schedules[16][5] = " ";
$schedules[17][0] = "15:00";
$schedules[17][1] = " ";
$schedules[17][2] = " ";
$schedules[17][3] = " ";
$schedules[17][4] = " ";
$schedules[17][5] = " ";
$schedules[18][0] = "15:30";
$schedules[18][1] = " ";
$schedules[18][2] = " ";
$schedules[18][3] = " ";
$schedules[18][4] = " ";
$schedules[18][5] = " ";
$schedules[19][0] = "16:00";
$schedules[19][1] = " ";
$schedules[19][2] = " ";
$schedules[19][3] = " ";
$schedules[19][4] = " ";
$schedules[19][5] = " ";
$schedules[20][0] = "16:30";
$schedules[20][1] = " ";
$schedules[20][2] = " ";
$schedules[20][3] = " ";
$schedules[20][4] = " ";
$schedules[20][5] = " ";
$schedules[21][0] = "17:00";
$schedules[21][1] = " ";
$schedules[21][2] = " ";
$schedules[21][3] = " ";
$schedules[21][4] = " ";
$schedules[21][5] = " ";
$schedules[22][0] = "17:30";
$schedules[22][1] = " ";
$schedules[22][2] = " ";
$schedules[22][3] = " ";
$schedules[22][4] = " ";
$schedules[22][5] = " ";
$schedules[23][0] = "18:00";
$schedules[23][1] = " ";
$schedules[23][2] = " ";
$schedules[23][3] = " ";
$schedules[23][4] = " ";
$schedules[23][5] = " ";
$schedules[24][0] = "18:30";
$schedules[24][1] = " ";
$schedules[24][2] = " ";
$schedules[24][3] = " ";
$schedules[24][4] = " ";
$schedules[24][5] = " ";
$schedules[25][0] = "19:00";
$schedules[25][1] = " ";
$schedules[25][2] = " ";
$schedules[25][3] = " ";
$schedules[25][4] = " ";
$schedules[25][5] = " ";
$schedules[26][0] = "19:30";
$schedules[26][1] = " ";
$schedules[26][2] = " ";
$schedules[26][3] = " ";
$schedules[26][4] = " ";
$schedules[26][5] = " ";
return $schedules;
// =======
// esta funcion imprime la tabla logica del horario
function printMat($matrix){
    $f=sizeof($matrix);
    $c=sizeof($matrix[0]);
    echo '<table  border="1">';
    for($i=0;$i<$f;$i++){
    echo "<tr>";
    for($j=0;$j<$c;$j++){
        echo "<td>";
            echo $matrix[$i][$j];
            echo "</td>";
    }
echo "</tr>";}
echo "</table>";
}

// Esta función crea el horario formato base del horario
function setSchedule($intv){
	$col = 6;
	$schedules[0][0] = "Horas";
	$schedules[0][1] = "Lunes";
    $schedules[0][2] = "Martes";
    $schedules[0][3] = "Miercoles";
    $schedules[0][4] = "Jueves";
    $schedules[0][5] = "Viernes";
    for($i=0;$i<$col;$i++){
    foreach ($intv as $interval) {
    	if($i==0){
    		$schedules[$interval->id][$i] = substr($interval->schedule,0,5);// schedule tiene el formato time (7:00:00), con substr simplificamos este formato (7:00)
    	}else{
    		$schedules[$interval->id][$i] = " ";
    	}
    }
    }
    return $schedules;
// >>>>>>> b0a001c9faad4ab679a5fae2392168fc2fe9cc85
}

//Esta función encuentra el id de las clases relacionadas con el profesor
function getIdClasses($instructorId,$subjectstoinstructors){
if($subjectstoinstructors){
$classes = array();
foreach ($subjectstoinstructors as $subjecttoinstructor){
if($subjecttoinstructor->id_instructor===$instructorId){
$classes[]= $subjecttoinstructor->id_subject;
}}
return $classes;}}



//Esta función nos regresa un array de objetos classes, los cuales son las clases pertenecientes a ese instructor
function getInstructorClasses($classesId,$clases){
$teacherClasses = array();
if($classesId){
$classesSize = count($classesId);
for($i=0;$i<=$classesSize-1;$i++){
foreach ($clases as $clase) {
	if($clase->id_subject===$classesId[$i]){
	$teacherClasses[]=$clase;
}}
}}return $teacherClasses;}


//Esta funcion llena el horario del maestro de acuerdo a los registros encontrados
function setClassesIntoSchedule($teacherClasses,&$schedule){
	$horas = [7.0,7.30,8.0,8.30,9.0,9.30,10.0,10.30,11.0,11.30,12.0,12.30,13.0,13.30,14.0,14.30,15.0,15.30,16.0,16.30,17.0,17.30,18.0,18.30,19.0,19.30,20.0,20.30,21.0,21.30,22.0,22.30];
//De esta manera accedemos a los objetos encontrados por maestro
if($teacherClasses){
$indice=count($teacherClasses);
	    for($i=0;$i<$indice;$i++){
// <<<<<<< HEAD
	    	for($j=0;$j<count($horas);$j++){
	    		if(isInRange($horas[$j],$teacherClasses[$i]->time_start,$teacherClasses[$i]->time_end)){
	    	$schedule[$j+1][$teacherClasses[$i]->day]= " Materia: ".$teacherClasses[$i]->subject->name."<br>"."Salón: ".$teacherClasses[$i]->room->room;
	           }
	    	} }
	    	   }}



//esta función es auxiliar en la selección de filas para establecer los datos
function isInRange($valor,$inf,$sup){
$inferior=substr($inf,0,5);
$superior=substr($sup,0,5);
$inferior=str_replace(':', '.', $inferior);
$superior=str_replace(':', '.', $superior);
$inferior=floatval($inferior);
$superior=floatval($superior);
if($inferior<=$valor and $valor<=$superior) return true;
else return false;
// =======
	    	$ini = false;
	    	$fin = false;
	    	for($j=0;$j<$f;$j++){
            if($schedule[$j][0]==substr($teacherClasses[$i]->time_start,0,5)and !$fin) {
            	$ini=true;
            }else{
            	if($schedule[$j][0]!=substr($teacherClasses[$i]->time_end,0,5) and $ini) {
            	$ini=true;
            	$fin=false;
            }else{
            		if($schedule[$j][0]==substr($teacherClasses[$i]->time_end,0,5) and $ini){
            			$ini=false;
            			$fin= true;
            			$schedule[$j][$teacherClasses[$i]->day]= " Materia: ".$teacherClasses[$i]->idSubject->name."<br>"."Salón: ".$teacherClasses[$i]->idRoom->room;
            		}
            	}
            }
            if(!$fin and $ini) $schedule[$j][$teacherClasses[$i]->day]= " Materia: ".$teacherClasses[$i]->idSubject->name."<br>"."Salón: ".$teacherClasses[$i]->idRoom->room;
	    	}
	    }}



function getSubjectLength($matrix,$row,$column){
$f=sizeof($matrix);
$counter = 1;
$stopCounting = false;
	for($i=$row+1;$i<$f;$i++){
        if($matrix[$i][$column]!=$matrix[$i-1][$column]) $stopCounting= true;
		if($matrix[$i][$column]==$matrix[$row][$column] and $matrix[$i][$column]==$matrix[$i-1][$column] and !$stopCounting)$counter++;
	}
	return $counter;
// >>>>>>> b0a001c9faad4ab679a5fae2392168fc2fe9cc85
}


?>
