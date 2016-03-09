<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_detalle = $_GET['id_detalle'];
$ingresada = $_GET['error'];

if (!empty($id_detalle)){


	//Datos del diseño genereal
	$pos_pag = "SELECT * FROM general WHERE id_pagina='$ids'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_gen = $row["id_general"]; 
		$ord_detalle = $row["ord_detalle"]; 
	}

	$n_menu = "SELECT COUNT(ord_detalle) FROM detalle WHERE id_general='$id_gen'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_detalle + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE detalle SET
					ord_detalle='$act'
					WHERE ord_detalle='$i' AND id_general='$id_gen'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM detalle WHERE id_detalle='$id_detalle'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar archivo :".$id_gen;
	
header("location: dise_general_detalle.php?id=$ids");

?>

