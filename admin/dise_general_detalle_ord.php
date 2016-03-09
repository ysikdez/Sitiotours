<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_detalle = $_GET['id_detalle'];
$signo = $_GET['sig'];
$ingresada = $_GET['error'];

$pos = "SELECT * FROM detalle WHERE id_detalle='$id_detalle'";
$posi = mysql_db_query($dbname, $pos); 
if ($row = mysql_fetch_array($posi)){ 

		$id_general = $row["id_general"]; 
		$ord_detalle = $row["ord_detalle"]; 

}

$i = $ord_detalle;
	

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE detalle SET
						ord_detalle='$ant'
						WHERE ord_detalle='$sig' AND id_general = $id_general";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE detalle SET
						ord_detalle='$sig'
						WHERE id_detalle='$id_detalle'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE detalle SET
						ord_detalle='$sig'
						WHERE ord_detalle='$ant' AND id_general = $id_general";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE detalle SET
						ord_detalle='$ant'
						WHERE id_detalle='$id_detalle'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_detalle;

header("location: dise_general_detalle.php?id=$ids&id_detalle=$id_detalle&error=$error");


?>

