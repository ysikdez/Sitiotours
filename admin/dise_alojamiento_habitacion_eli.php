<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_habitacion = $_GET['id_habitacion'];
$error = $_GET['error'];

if (!empty($id_habitacion)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM habitacion WHERE id_habitacion='$id_habitacion'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_alojamiento = $row["id_alojamiento"]; 
		$ord_habitacion = $row["ord_habitacion"]; 
	}

	$n_menu = "SELECT COUNT(ord_habitacion) FROM habitacion WHERE id_alojamiento='$id_alojamiento'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_habitacion + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE habitacion SET
					ord_habitacion='$act'
					WHERE ord_habitacion='$i' AND id_alojamiento='$id_alojamiento'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM habitacion WHERE id_habitacion='$id_habitacion'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el habitacion :".$ord_habitacion;
	
header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");

?>

