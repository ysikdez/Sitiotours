<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
//$id_habitacion = $_GET['id_habitacion'];
$id_hprecio = $_GET['id_hprecio'];
$error = $_GET['error'];

if (!empty($id_hprecio)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM hprecio WHERE id_hprecio='$id_hprecio'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_habitacion = $row["id_habitacion"]; 
		$ord_hprecio = $row["ord_hprecio"]; 
	}

	$n_menu = "SELECT COUNT(ord_hprecio) FROM hprecio WHERE id_habitacion='$id_habitacion'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_hprecio + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE hprecio SET
					ord_hprecio='$act'
					WHERE ord_hprecio='$i' AND id_habitacion='$id_habitacion'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM hprecio WHERE id_hprecio='$id_hprecio'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Precio de la Habitacion :".$ord_hprecio;
	
header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");

?>

