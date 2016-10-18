
<h1>Esta es la vista de <?php echo $section;?></h1><br>

<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

foreach ($model as $instructor) {
		
	    echo "<h4> Horario del profesor ".$instructor->name." ".$instructor->last_name."</h4> <br>";
	    $idmaterias = getIdClasses($instructor->id,$subjectstoinstructors);
	    $teacherClasses = getInstructorClasses($idmaterias,$clases);
	    $horario=setSchedule($interval);
	    setClassesIntoSchedule2($teacherClasses,$horario);
        echo "<br>";
        printMatrix($horario);
        echo "<br> <br>";
        unset($materias);
        unset($teacherClasses);
		}

//Función que imprime los horarios
function printMatrix($matrix){
	$f=sizeof($matrix);
	$c=sizeof($matrix[0]);
	echo '<table  border="1">';
for($i=0;$i<$f;$i++){
	echo "<tr>";
	for($j=0;$j<$c;$j++){
		if($i==0 or $j==0){
			echo "<td>";
	        echo $matrix[$i][$j];
		    echo "</td>";	}
		    else{
            if($matrix[$i-1][$j]!=$matrix[$i][$j] and $matrix[$i][$j]!=" "){
            $size = getSubjectLength($matrix,$i,$j);
            echo '<td rowspan="'.$size.'">';
	        echo $matrix[$i][$j];//$matrix[$i][$j];
		    echo "</td>";
            }else{
            	if($matrix[$i][$j]==" "){
            echo "<td>";
	        echo $matrix[$i][$j];
		    echo "</td>";}            
            } }			
	}
	echo "</tr>";
}
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
function setClassesIntoSchedule2($teacherClasses,&$schedule){
if($teacherClasses){
$f=sizeof($schedule);
$indice=count($teacherClasses);
	    for($i=0;$i<$indice;$i++){
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
	    }}}



function getSubjectLength($matrix,$row,$column){
$f=sizeof($matrix);
$counter = 1;
	for($i=$row+1;$i<$f;$i++){
		if($matrix[$i][$column]==$matrix[$row][$column])$counter++;
	}
	return $counter;
}

?>


