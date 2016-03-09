<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_hprecio = $_GET['id_hprecio'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM hprecio WHERE id_hprecio='$id_hprecio'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_habitacion = $row["id_habitacion"]; 
	$ord_hprecio = $row["ord_hprecio"]; 
}

$i = $ord_hprecio;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE hprecio SET
						ord_hprecio='$ant'
						WHERE ord_hprecio='$sig' AND id_habitacion = $id_habitacion";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE hprecio SET
						ord_hprecio='$sig'
						WHERE id_hprecio='$id_hprecio'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE hprecio SET
						ord_hprecio='$sig'
						WHERE ord_hprecio='$ant' AND id_habitacion = $id_habitacion";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE hprecio SET
						ord_hprecio='$ant'
						WHERE id_hprecio='$id_hprecio'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_hprecio;

header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");


?>

