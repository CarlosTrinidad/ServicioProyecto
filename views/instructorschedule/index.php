<? php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
?>

<!--
<h1>Esta es la vista de <?php echo $section;?></h1>

<?php foreach ($model as $instructor) {
		echo "<h4>".$instructor->id.". ".$instructor->name." ".$instructor->last_name."<br>";
		}
?>

<h1> Estas son las materias registradas </h1>
<?php foreach ($materias as $materia) {
		echo "<h4>".$materia->id.". ".$materia->name."<br>";
		}
?>

<h1> Estas son las clases registradas </h1>
<?php foreach ($clases as $clase) {
		echo "<h4>".$clase->id.", "."Materia: ".$clase->subject->name.", Salón: ".$clase->room->room.", Hora de inicio:".$clase->time_start."</h4>";
		echo "<ul>";
		foreach($clase->subject->instructorSubjects as $instructorSubject){
			echo "<li>" . $instructorSubject->instructor->name . " " . $instructorSubject->instructor->last_name . "</li>";
		}
		echo "</ul>";
	   //echo var_dump($clase->getIdSubject());
		}
?> 
 -->

<?php
//Prueba de los codigos que crean los horarios

$horario=setSchedule();
printMatrix($horario);
?>

<?php
//Función que imprime los horarios
function printMatrix($matrix){
	$f=sizeof($matrix);
	$c=sizeof($matrix[0]);
	echo "<table>";
for($i=0;$i<$f;$i++){
	echo "<tr>";
	for($j=0;$j<$c;$j++){
		echo "<td>";
	echo $matrix[$i][$j];
		echo "</td>";	
	}
	echo "</tr>";
}
echo "</table>";
}
?>

<?php
//Funcion que crea el horario
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
return $schedules;
}
?>