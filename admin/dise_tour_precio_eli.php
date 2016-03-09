<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_tprecio = $_GET['id_tprecio'];
$ingresada = $_GET['error'];

if (!empty($id_tprecio)){

	// //Datos del diseño genereal
	// $pos_pag = "SELECT * FROM general WHERE id_pagina='$ids'";
	// $posi_pag = mysql_db_query($dbname, $pos_pag); 
	// if ($row = mysql_fetch_array($posi_pag)){ 
	// 	$id_gen = $row["id_general"]; 
	// 	$ord_detalle = $row["ord_detalle"]; 
	// }

	// $n_menu = "SELECT COUNT(ord_detalle) FROM detalle WHERE id_general='$id_gen'";
	// $max = mysql_db_query($dbname, $n_menu);
	// $max = mysql_result($max, 0);

	// $sig = $ord_detalle + 1;
				
	// for ($i = $sig ; $i <= $max ; $i++) {
		
	// 	$act = $i - 1 ;
		
	// 	if ( $act > 0 ){
	// 		//Cambia la posicion de las paginas que no son borradas
	// 		$cam_posi = "UPDATE detalle SET
	// 				ord_detalle='$act'
	// 				WHERE ord_detalle='$i' AND id_general='$id_gen'";
	// 		$cab_actual = mysql_db_query($dbname, $cam_posi);	
	// 	}
	// }
		
	$modificar = "DELETE FROM tprecio WHERE id_tprecio='$id_tprecio'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Precio :".$id_tprecio;
	
header("location: dise_tour_precio.php?id=$ids&error=$error");

?>

