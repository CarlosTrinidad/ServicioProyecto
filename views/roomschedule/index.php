<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
?>
<h2>Listado de Salones</h2>
<table border="1">
<tr></tr>
 <?php foreach ($model as $room) { ?>
 	<table border="2">
 	<tbody>
 	<tr><td colspan="3">Room Name: <?php echo $room->room ?></td><td colspan="4">Room Capacity  <?php echo $room->capacity ?></td></tr>
 	<tr><td>Horario</td><td>Lunes</td><td>Martes</td><td>Miércoles</td><td>Jueves</td><td>Viernes</td><td>Sábado</td></tr>
 	<br>
 <?php } ?>
</table>

<h2>Listado de Salones</h2>
<?php foreach ($clases as $classes) { ?>
<table border="1">
<tbody>
	<tr><td colspan="7"><?php echo $room->room ?></td></tr>
	<tr><td>Horario</td><td>Lunes</td><td>Martes</td><td>Miércoles</td><td>Jueves</td><td>Viernes</td><td>Sábado</td></tr>
</tbody>
<br>
<?php } ?>
</table>



<center><h1>Horario Agosto - Diciembre 2016 - Vista de <?php echo $section;?></h1></center><br>
<?php
$classes_arr = array(
	// Clase para el día Lunes (Día 0)
	0 => array(
			// Se agrega una clase que comienza a las 11:00
			1115 => array(
				"html" => "<b>Estructura de Datos</b><br><b><i>IC(2013)-MEFI</i></b><br>D3 Legarda Sáenz, Ricardo",
				"style" => "border: black 1px; background-color: #66CCCC;", // use style property to change the background color
				"interval" => 120 // set the interval for 2hrs
				),
			1400 => array(
				"html" => "<b>Física</b><br><b><i>IC-IC(2013)-MEFI</i></b><br>D3 Aguayo González, Aarón",
				"style" => "border: blakc 1px; background-color: #66CCCC", // use style property to change the background color
				"interval" => 120 // set the interval for 2hrs
			)	
	),
	
	// Clase para el día Jueves (Día 3)
	3 => array(
			// Adds a class at 11:00 (1100 hours)
			1100 => array(
				"html" => "<b>Física</b><br>IC-IC(2013)-MEFI<br>D3 Aguayo González, Aarón",
				 "interval" => 120 // set the interval for 2hrs
			)
	),
	// Clase para el día Jueves (Día 3)
);

$options = array( 
			"row_interval" => 15, // Intervalo de separacion de las horas
			"start_time" => 730, // Tiempo de inicio del horario 07:30
			"end_time" => 2100,   // Tiempo final del horario 21:00
			"title" => "C1",
			"title_style" => "font-family: calibri; font-size: 14pt;", // estilo css del titulo
			"time_style" => "font-family: calibri; font-size: 12pt;",  // estilo css de la selda de tiempo
			"dayheader_style" => "font-family: calibri; font-size: 10pt;", // estilo css de las seldas de cabecera de los dias
			
			// estilo css por default de las celdas de clases
			"class_globalstyle" => "border: 1px; background-color: #c0c0c0; font-family: calibri; font-size: 11pt; text-align: center;", 
);

echo schedule_generate($classes_arr, $options);
?>

<?php
function schedule_generate($classes_arr, $options) {

		// Si no se establece el intervalo de fila o es cero se inserta por defecto 30min 
		if ( intval($options["row_interval"]) == 0 ) $options["row_interval"] = 30;	

		// Define como hora de inicio 07:30 si no se establece
		if ( ! isset($options["start_time"]) ) {
			$options["start_time"] = 730;
		}
		else {
			// change to the nearest row interval hour down
			$time_hour = ($options["start_time"] - $options["start_time"] % 100) / 100; 
			$time_min = $options["start_time"] % 100;
			
			$time_totalmins = $time_hour * 60 + $time_min;
			
			if ( $time_totalmins % $options["row_interval"] > 0) $time_totalmins = $time_totalmins - $time_totalmins % $options["row_interval"];
			$options["start_time"] = ($time_totalmins - $time_totalmins % 60) / 60 * 100 + $time_totalmins % 60;
		
		}
		
		
		// Define la hora final como 21:00 si no se establece
		if ( ! isset($options["end_time"]) ) {
			$options["end_time"] = 2100;
		}
		else {
			// change to the nearest row interval hour down.
			$time_hour = ($options["end_time"] - $options["end_time"] % 100) / 100; 
			$time_min = $options["end_time"] % 100;
			
			$time_totalmins = $time_hour * 60 + $time_min;
			
			if ( $time_totalmins % $options["row_interval"] > 0) $time_totalmins = $time_totalmins - $time_totalmins % $options["row_interval"];
			$options["end_time"] = ($time_totalmins - $time_totalmins % 60) / 60 * 100 + $time_totalmins % 60;
		
		}

		$days_arr = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
		$days_norow = array(0, 0, 0, 0, 0, 0);

		
		$html = "<table border=1px width=\"100%\" bgcolor=\"#000000\" cellspacing=\"1\" cellpadding=\"0\">\n";
		
		// output title if set in $options.
		if ( isset($options["title"]) ) {
			$cell_style = "background-color: #000; color: #ffffff; border: 1px;"; // default title style 
 			$cell_style .= $options["title_style"];
			
			$html .= "	<tr>\n		<th colspan=\"8\" style=\"$cell_style\">".$options["title"]."</th>\n	</tr>\n";
		}
		
		$cell_style = "border: 1px; background-color: #c0c0c0; color: #000000;"; // default day header style
		$cell_style .= $options["dayheader_style"];
		
		$html .= "	<tr style=\"$cell_style\">\n		<th></th>\n";
		foreach ($days_arr as $day){
			$html .= "		<th>$day</th>\n";
		}
		$html .= "	</tr>\n";
		
		$cur_time = $options["start_time"];
		while ($cur_time < $options["end_time"]) {
			$format_time = date("H:i", strtotime(substr($cur_time, 0, strlen($cur_time) - 2).":".substr($cur_time, -2, 2)));
			
			$cell_style = "background-color: #c0c0c0; color: #000000;"; // default time cell style
			$cell_style .= $options["time_style"];			
				
			$html .= "	<tr bgcolor=\"#ffffff\">\n		<td align=\"center\" width=\"2%\" style=\"$cell_style\"><b>$format_time</b></td>\n";
			for ($cur_day = 0; $cur_day < 6; $cur_day++) {
			
				// if flag is set not to print any row for the next
				// row (since a class spans more than one row), then
				// continue.
				if ($days_norow[$cur_day] > 0) {
					$days_norow[$cur_day]--;
					continue;
				}
			
			
				 // check if there is a class during this day/time
				if ( isset($classes_arr[$cur_day][$cur_time]) ) {
					
						$class_interval = intval($classes_arr[$cur_day][$cur_time]["interval"]);
						if ( $class_interval == 0 ) $class_interval = 60; // default interval is 60mins
						
						// round to nearest interval
						$class_span = intval($class_interval / $options["row_interval"]);
						
						// flag that for the next $class_span rows, we should not print a cell
						$days_norow[$cur_day] += $class_span - 1;		
					
					    if ( isset($classes_arr[$cur_day][$cur_time]["style"]) )
							$cell_style = $options["class_globalstyle"]."; ".$classes_arr[$cur_day][$cur_time]["style"];
						else
							$cell_style = $options["class_globalstyle"];
						
						$html .= "		<td width=\"14%\" rowspan=\"$class_span\" style=\"$cell_style\">".$classes_arr[$cur_day][$cur_time]["html"]."</td>\n";
						
				}		
				else {
						$html .= "		<td width=\"14%\">&nbsp;</td>\n";		
					
				
				}
				
				
			}
		
			
			$html .= "	</tr>\n";
			
			$cur_time += $options["row_interval"]; // increment to next row interval
			if ($cur_time % 100 >= 60) $cur_time = $cur_time - $cur_time % 100 + 100;
		};
				
		
		
		$html .= "</table>\n";
		
		
		return $html;	
	
}
?>