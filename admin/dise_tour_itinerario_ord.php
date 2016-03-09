<?php
include ("config.php");

$ids= $_GET['id'];
$signo = $_GET['sig'];
$id_itinerario = $_GET['id_itinerario'];

//Datos del tour
$pos_tour = "SELECT * FROM tour WHERE id_pagina='$ids'";
$posi_tour = mysql_db_query($dbname, $pos_tour); 
if ($row = mysql_fetch_array($posi_tour)){ $id_pag_tour = $row["id_tour"]; }

//Datos del Itinerario
$l_pos = "SELECT * FROM itinerario WHERE id_itinerario='$id_itinerario'";
$l_posi = mysql_db_query($dbname, $l_pos); 
if ($row = mysql_fetch_array($l_posi)){	$pos = $row["ord_itinerario"]; }

$i = $pos;
	

if (!empty($i)){

	if ($signo == 1){
		
			$sig=$i+1;
			$ant=$i;
			
			//el Itinerario siguiente retrocede 
			$siguiente = "UPDATE itinerario SET
						ord_itinerario='$ant'
						WHERE ord_itinerario='$sig' AND id_tour='$id_pag_tour'";
			$cab_actual = mysql_db_query($dbname, $siguiente);

			//el Itinerario actual se va a la siguiente 
			$actual = "UPDATE itinerario SET
						ord_itinerario='$sig'
						WHERE id_itinerario='$id_itinerario'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE itinerario SET
						ord_itinerario='$sig'
						WHERE ord_itinerario='$ant' AND id_tour='$id_pag_tour'";
			$cab_actual = mysql_db_query($dbname, $anterior);	

			$actual = "UPDATE itinerario SET
						ord_itinerario='$ant'
						WHERE id_itinerario='$id_itinerario'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$pos;

			
header("location: dise_tour_itinerario.php?id=$ids&error=$error");


?>

