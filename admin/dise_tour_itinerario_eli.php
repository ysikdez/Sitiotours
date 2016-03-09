<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_itinerario = $_GET['id_itinerario'];
$ingresada = $_GET['error'];

if (!empty($ids) || !empty($id_itinerario)){

	//Datos del tour
	$pos_tour = "SELECT * FROM tour WHERE id_pagina='$ids'";
	$posi_tour = mysql_db_query($dbname, $pos_tour); 
	if ($row = mysql_fetch_array($posi_tour)){ $id_pag_tour = $row["id_tour"]; }

	//Datos del Itinerario
	$l_pos = "SELECT * FROM itinerario WHERE id_itinerario='$id_itinerario'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){	$pos = $row["ord_itinerario"]; }

	//Numero de Itinerario
	$indice = "SELECT COUNT(id_itinerario) FROM itinerario WHERE id_tour='$id_pag_tour'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);

	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE itinerario SET
						ord_itinerario='$act'
						WHERE id_tour='$id_pag_tour' AND ord_itinerario='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM iincluye WHERE id_itinerario='$id_itinerario'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM itinerario WHERE id_itinerario='$id_itinerario'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar archivo :".$id_itinerario;
	
header("location: dise_tour_itinerario.php?id=$ids&error=$error");

?>

