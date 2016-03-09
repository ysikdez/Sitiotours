<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_habitacion = $_GET['id_habitacion'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM habitacion WHERE id_habitacion='$id_habitacion'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_alojamiento = $row["id_alojamiento"]; 
	$ord_habitacion = $row["ord_habitacion"]; 
}

$i = $ord_habitacion;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE habitacion SET
						ord_habitacion='$ant'
						WHERE ord_habitacion='$sig' AND id_alojamiento = $id_alojamiento";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE habitacion SET
						ord_habitacion='$sig'
						WHERE id_habitacion='$id_habitacion'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE habitacion SET
						ord_habitacion='$sig'
						WHERE ord_habitacion='$ant' AND id_alojamiento = $id_alojamiento";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE habitacion SET
						ord_habitacion='$ant'
						WHERE id_habitacion='$id_habitacion'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_habitacion;

header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");


?>

