<?php
use yii\helpers\registerCss;
use yii\helpers\Html;


$this->title = Yii::t('app', 'Horario de Profesor');

//Se aplican estilos al horario
$this->registerCss("table {width: 80%; margin: 0 auto; border:#000000;} td.c{background-color:#FACC2E; color:#0B0B61; font-weight: bold;}  td{width: 13%; text-align: center;} td.rw{background-color:#0B0B61;color:#FACC2E} .emptyRow{ background-color:#FFFFFF;}");


//Se despliega información del maestro
echo "<br><br><br><h4> Horario del profesor ".$instructor->name." ".$instructor->last_name."</h4> <br>";
$horario=setSchedule($interval);


// Se obtienen las clases y se despliegan
echo "<br>";
	foreach($instructor->subjects as $subject)
		{
           // print_r($subject->programSubjects);
setClassesIntoSchedule2($subject->classes,$horario);
		}
printMatrix($horario);






		// Esta función crea el horario formato base del horario
function setSchedule($intv){
    $index = 1;
	$col = 6;
	$schedules[0][0] = "";
	$schedules[0][1] = "Lunes";
    $schedules[0][2] = "Martes";
    $schedules[0][3] = "Miércoles";
    $schedules[0][4] = "Jueves";
    $schedules[0][5] = "Viernes";
    for($i=0;$i<$col;$i++){
    foreach ($intv as $interval) {
    	if($i==0){
    		$schedules[$index][$i] = substr($interval->schedule,0,5);// schedule tiene el formato time (7:00:00), con substr simplificamos este formato (7:00)
    	}else{
    		$schedules[$index][$i] = " ";
    	}
        $index++;
    }
        $index = 1;
    }

    return $schedules;
}

//Función que imprime los horarios
function printMatrix($matrix){
	$f=sizeof($matrix);
	$c=sizeof($matrix[0]);
	// echo '<table  border="1" width: 100% class="ScheduleTable">';
	// Yii format
	echo '<table class="table table-striped table-bordered">';
for($i=0;$i<$f;$i++){
	echo "<tr>";
	for($j=0;$j<$c;$j++){
		if($i==0 or $j==0){
			echo '<td class="rw">';
	        echo $matrix[$i][$j];
		    echo "</td>";	}
		    else{
            if($matrix[$i-1][$j]!=$matrix[$i][$j] and $matrix[$i][$j]!=" "){
            $size = getSubjectLength($matrix,$i,$j);
            echo '<td rowspan="'.$size.'" class="c">';

					$beforeColon = substr($matrix[$i][$j], strpos($matrix[$i][$j],']')+1);
					$id_class = substr($matrix[$i][$j], 0 , strpos($matrix[$i][$j],']'));
					echo $beforeColon;
					echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['classes/update', 'id' => $id_class, 'return' => 'yes' ]);
					echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['classes/delete', 'id' => $id_class, 'return' => 'yes'], [
					                'class' => '',
					                'data' => [
					                    'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
					                    'method' => 'post',
					                ],
					            ]);
		    echo "</td>";
            }else{
            	if($matrix[$i][$j]==" "){
            echo '<td class="emptyRow">';
	        echo $matrix[$i][$j];
	        // echo $matrix[$i][0].":00";
					echo Html::a('<span class="glyphicon glyphicon-plus"></span>', ['classes/create', 'day' => $j, 'time_start' => $matrix[$i][0].":00", 'return' => 'yes' ]);
				echo "</td>";}
            } }
	}
	echo "</tr>";
}
echo "</table>";
}

//Esta funcion llena el horario del maestro de acuerdo a los registros encontrados
function setClassesIntoSchedule2($teacherClasses,&$schedule){
if($teacherClasses){
$programas = array();
$f=sizeof($schedule);
$indice=count($teacherClasses);
	    for($i=0;$i<$indice;$i++){
//Enlistamos los programas a los que pertenece la materia
               foreach ($teacherClasses[$i]->idSubject->programSubjects as $program) {
                $programas[] = $program->idProgram->name;
            }
            $prog = implode(",", $programas);
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
            			$schedule[$j][$teacherClasses[$i]->day]= $teacherClasses[$i]->id."]"." Materia: ".$teacherClasses[$i]->idSubject->name."<br>"."Salón: ".$teacherClasses[$i]->idRoom->room."<br>".$prog;
            		}
            	}
            }
            if(!$fin and $ini) $schedule[$j][$teacherClasses[$i]->day]= $teacherClasses[$i]->id."]"." Materia: ".$teacherClasses[$i]->idSubject->name."<br>"."Salón: ".$teacherClasses[$i]->idRoom->room."<br>".$prog;
	    	}
	    unset($programas);
        $programas = array();
}}}

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
?>
